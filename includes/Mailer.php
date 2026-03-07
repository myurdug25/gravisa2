<?php
/**
 * Basit e-posta gönderici
 * PHP mail() veya SMTP kullanır
 */

class Mailer
{
    private $to;
    private $from;
    private $fromName;
    private $subject;
    private $body;
    private $headers = [];

    public function __construct()
    {
        $settings = function_exists('getSettings') ? getSettings() : [];
        $this->to = !empty($settings['mail_to']) ? $settings['mail_to'] : (defined('MAIL_TO') ? MAIL_TO : '');
        $this->from = !empty($settings['mail_from']) ? $settings['mail_from'] : (defined('MAIL_FROM') ? MAIL_FROM : '');
        $this->fromName = !empty($settings['mail_from_name']) ? $settings['mail_from_name'] : (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Gravisa');
    }

    public function setTo(string $email): self
    {
        $this->to = $email;
        return $this;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function setHtmlBody(string $html): self
    {
        $this->headers['Content-Type'] = 'Content-Type: text/html; charset=UTF-8';
        $this->body = $html;
        return $this;
    }

    /**
     * Form verilerinden HTML e-posta gövdesi oluşturur
     */
    public function buildHtmlFromData(array $data, string $title): string
    {
        $rows = '';
        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) continue;
            $label = $this->formatLabel($key);
            $rows .= "<tr><td style='padding:8px 12px;border:1px solid #e0e0e0;font-weight:600;width:180px;'>{$label}</td>";
            $rows .= "<td style='padding:8px 12px;border:1px solid #e0e0e0;'>" . htmlspecialchars((string)$value) . "</td></tr>";
        }
        return "
        <!DOCTYPE html>
        <html><head><meta charset='UTF-8'></head>
        <body style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>
        <h2 style='color:#1e5f8a;'>{$title}</h2>
        <p style='color:#666;'>Aşağıda web sitesinden gelen talep bilgileri yer almaktadır.</p>
        <table style='border-collapse:collapse; width:100%; max-width:600px;'>
        {$rows}
        </table>
        <p style='margin-top:24px; font-size:12px; color:#999;'>Bu e-posta Gravisa web sitesi üzerinden otomatik gönderilmiştir.</p>
        </body></html>";
    }

    private function formatLabel(string $key): string
    {
        $map = [
            'ad_soyad' => 'Ad Soyad',
            'name' => 'Ad Soyad',
            'email' => 'E-posta',
            'telefon' => 'Telefon',
            'phone' => 'Telefon',
            'firma' => 'Firma / Ünvan',
            'lokasyon' => 'Şantiye / Adres',
            'sure' => 'Kiralama Süresi',
            'operator' => 'Operatör',
            'baslangic' => 'Başlangıç Tarihi',
            'bitis' => 'Bitiş Tarihi',
            'model' => 'Model',
            'makine_id' => 'Makine ID',
            'makine_model' => 'Makine Model',
            'adet' => 'Adet',
            'machine' => 'İlgilendiği Makine',
            'date' => 'Tercih Edilen Tarih',
            'note' => 'Not',
            'not' => 'Ek Notlar',
            'konu' => 'Konu',
            'mesaj' => 'Mesaj',
            'created_at' => 'Tarih',
        ];
        return $map[$key] ?? ucfirst(str_replace('_', ' ', $key));
    }

    /** Müşteriye cevap e-postası gönderir (talep sahibinin e-postasına) */
    public function sendReplyToCustomer(string $customerEmail, string $customerName, string $replyText, string $requestSubject = 'Talebiniz'): bool
    {
        if (empty($customerEmail) || !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">';
        $html .= '<h2 style="color:#1e5f8a;">Gravisa – Talebinize Cevap</h2>';
        $html .= '<p>Sayın ' . htmlspecialchars($customerName) . ',</p>';
        $html .= '<p>' . nl2br(htmlspecialchars($replyText)) . '</p>';
        $html .= '<p style="margin-top: 24px; color: #666;">Saygılarımızla,<br />Gravisa Ekibi</p>';
        $html .= '</body></html>';
        $this->to = $customerEmail;
        $this->setSubject('[Gravisa] ' . $requestSubject . ' – Cevabımız');
        $this->setHtmlBody($html);
        return $this->send();
    }

    public function send(): bool
    {
        if (defined('MAIL_SMTP_HOST') && MAIL_SMTP_HOST !== '') {
            return $this->sendViaSmtp();
        }
        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $this->fromName . ' <' . $this->from . '>',
            'Reply-To: ' . $this->from,
            'X-Mailer: PHP/' . phpversion(),
        ];
        return @mail($this->to, $this->subject, $this->body, implode("\r\n", $headers));
    }

    /** Hostinger vb. SMTP ile gönderim */
    private function sendViaSmtp(): bool
    {
        $host = defined('MAIL_SMTP_HOST') ? MAIL_SMTP_HOST : '';
        $port = defined('MAIL_SMTP_PORT') ? (int) MAIL_SMTP_PORT : 587;
        $user = defined('MAIL_SMTP_USER') ? MAIL_SMTP_USER : '';
        $pass = defined('MAIL_SMTP_PASS') ? MAIL_SMTP_PASS : '';
        $secure = (defined('MAIL_SMTP_SECURE') && strtolower(MAIL_SMTP_SECURE) === 'ssl') ? 'ssl' : 'tls';

        $errno = 0;
        $errstr = '';
        $target = ($secure === 'ssl' && $port == 465 ? 'ssl://' . $host : $host) . ':' . $port;
        $fp = @stream_socket_client($target, $errno, $errstr, 15, STREAM_CLIENT_CONNECT);
        if (!$fp) {
            return false;
        }
        stream_set_timeout($fp, 10);

        $read = function () use ($fp) {
            $r = '';
            while ($line = fgets($fp, 515)) {
                $r .= $line;
                if (strlen($line) < 4 || substr($line, 3, 1) === ' ') break;
            }
            return $r;
        };

        $send = function ($cmd) use ($fp, $read) {
            fwrite($fp, $cmd . "\r\n");
            return $read();
        };

        $read();
        $send("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        if ($secure === 'tls' && $port === 587) {
            $send("STARTTLS");
            stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            $send("EHLO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        }
        if ($user && $pass) {
            $send("AUTH LOGIN");
            $send(base64_encode($user));
            $send(base64_encode($pass));
        }
        $send("MAIL FROM:<" . $this->from . ">");
        $send("RCPT TO:<" . $this->to . ">");
        $send("DATA");
        $msg = "From: " . $this->fromName . " <" . $this->from . ">\r\n";
        $msg .= "To: " . $this->to . "\r\n";
        $msg .= "Subject: =?UTF-8?B?" . base64_encode($this->subject) . "?=\r\n";
        $msg .= "MIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n";
        $msg .= $this->body . "\r\n.";
        $send($msg);
        $send("QUIT");
        fclose($fp);
        return true;
    }
}
