import re
import sys

# Encoding sorununu çöz
sys.stdout.reconfigure(encoding='utf-8')

# Dosyayı oku
with open('makpark.txt', 'r', encoding='utf-8') as f:
    lines = f.readlines()

# İlk 2 satırı atla (başlık)
data_lines = lines[2:]

machines = []
img_counter = 1

for line in data_lines:
    line = line.strip()
    if not line:
        continue
    
    # Tab ile ayrılmış sütunları parse et
    parts = line.split('\t')
    
    if len(parts) < 9:
        continue
    
    no = parts[0].strip()
    tip = parts[1].strip()
    firma = parts[2].strip()
    tipModel = parts[3].strip()
    modelYil = parts[4].strip()
    guc = parts[5].strip()
    kapasite = parts[6].strip()
    saseSeriNo = parts[7].strip()
    motorSeriNo = parts[8].strip()
    
    # Güç birimini parse et
    gucBirim = 'kW'
    gucValue = ''
    if 'kW' in guc:
        gucValue = guc.replace('kW', '').strip()
        gucBirim = 'kW'
    elif 'HP' in guc:
        gucValue = guc.replace('HP', '').strip()
        gucBirim = 'HP'
    elif 'kVA' in guc:
        gucValue = guc.replace('kVA', '').strip()
        gucBirim = 'kVA'
    else:
        gucValue = guc.strip()
        if gucValue:
            gucBirim = 'kW'  # varsayılan
    
    # Görsel atama (döngüsel)
    img = f'assets/machine-{img_counter}.png'
    img_counter = (img_counter % 6) + 1
    
    # Motor marka ve tip bilgisi yok, boş bırak
    motorMarka = ''
    motorTip = ''
    
    # Stok durumu varsayılan olarak true
    stok = True
    
    machine = {
        'id': len(machines) + 1,
        'no': no,
        'tip': tip,
        'firma': firma,
        'tipModel': tipModel,
        'modelYil': modelYil if modelYil else '',
        'guc': gucValue,
        'gucBirim': gucBirim,
        'kapasite': kapasite if kapasite else '',
        'saseSeriNo': saseSeriNo if saseSeriNo else '',
        'motorSeriNo': motorSeriNo if motorSeriNo else '',
        'motorMarka': motorMarka,
        'motorTip': motorTip,
        'img': img,
        'stok': stok
    }
    
    machines.append(machine)

# JavaScript formatında yazdır - UTF-8 encoding ile dosyaya yaz
import codecs

# String değerlerini escape et
def escape_js(s):
    if not s:
        return ''
    return str(s).replace("'", "\\'").replace("\\", "\\\\").replace("\n", "\\n").replace("\r", "")

# app-makineler.js dosyasını oku
with codecs.open('assets/js/app-makineler.js', 'r', encoding='utf-8') as f:
    js_content = f.read()

# makineler array'ini oluştur
array_lines = []
for i, m in enumerate(machines):
    comma = ',' if i < len(machines) - 1 else ''
    line = f"    {{ id: {m['id']}, no: '{m['no']}', tip: '{escape_js(m['tip'])}', firma: '{escape_js(m['firma'])}', tipModel: '{escape_js(m['tipModel'])}', modelYil: '{escape_js(m['modelYil'])}', guc: '{escape_js(m['guc'])}', gucBirim: '{escape_js(m['gucBirim'])}', kapasite: '{escape_js(m['kapasite'])}', saseSeriNo: '{escape_js(m['saseSeriNo'])}', motorSeriNo: '{escape_js(m['motorSeriNo'])}', motorMarka: '{escape_js(m['motorMarka'])}', motorTip: '{escape_js(m['motorTip'])}', img: '{escape_js(m['img'])}', stok: {str(m['stok']).lower()} }}{comma}"
    array_lines.append(line)

new_array = '  var makineler = [\n' + '\n'.join(array_lines) + '\n  ];'

# Eski array'i bul ve değiştir
import re
pattern = r'var makineler = \[.*?\];'
new_content = re.sub(pattern, new_array, js_content, flags=re.DOTALL)

# Dosyaya yaz
with codecs.open('assets/js/app-makineler.js', 'w', encoding='utf-8') as f:
    f.write(new_content)

print(f'{len(machines)} makine verisi app-makineler.js dosyasına eklendi.')
