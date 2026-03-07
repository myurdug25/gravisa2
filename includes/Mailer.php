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
        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $this->fromName . ' <' . $this->from . '>',
            'Reply-To: ' . $this->from,
            'X-Mailer: PHP/' . phpversion(),
        ];

        return @mail($this->to, $this->subject, $this->body, implode("\r\n", $headers));
    }
}
