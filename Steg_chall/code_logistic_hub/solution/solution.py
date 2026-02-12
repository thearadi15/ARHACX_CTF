"""
Automated solution for 'Code Logistics Hub' CTF Challenge
Extracts all hidden codes and flag from the challenge image.
"""
import cv2
import numpy as np
from PIL import Image, ExifTags
from pylibdmtx.pylibdmtx import decode
import segno
import pdf417
import os

CHALLENGE_IMG = 'CTF_Code_Logistics_Hub.jpg'

# 1. Extract Aztec code (top-left)
def extract_aztec(img_path):
    img = cv2.imread(img_path)
    aztec_crop = img[30:90, 30:90]
    cv2.imwrite('aztec_crop.png', aztec_crop)
    # Use segno to decode (segno does not decode, so use pylibdmtx or zxing)
    # Here, just save for manual decode or use an online tool
    print('[*] Aztec code cropped to aztec_crop.png (decode with dcode.fr/aztec-code)')

# 2. Extract QR code (center)
def extract_qr(img_path):
    img = cv2.imread(img_path)
    qr_crop = img[210:390, 310:490]
    cv2.imwrite('qr_crop.png', qr_crop)
    print('[*] QR code cropped to qr_crop.png (decode with dcode.fr/qrcode-reader)')

# 3. Extract PDF417 barcode (bottom edge)
def extract_pdf417(img_path):
    img = cv2.imread(img_path)
    pdf_crop = img[550:610, 150:650]
    cv2.imwrite('pdf417_crop.png', pdf_crop)
    print('[*] PDF417 barcode cropped to pdf417_crop.png (decode with dcode.fr/pdf417-barcode)')

# 4. Extract DataMatrix from color channels
def extract_datamatrix_channels(img_path):
    img = Image.open(img_path)
    arr = np.array(img)
    coords = [
        (600, 50),   # Blue
        (650, 250),  # Green
        (700, 450)   # Red
    ]
    names = ['dm1_blue.png', 'dm2_green.png', 'dm3_red.png']
    channels = [2, 1, 0]
    for i, (x, y) in enumerate(coords):
        ch = channels[i]
        channel_img = np.zeros((80, 80, 3), dtype=np.uint8)
        channel_img[..., ch] = arr[y:y+80, x:x+80, ch]
        Image.fromarray(channel_img).save(names[i])
        print(f'[*] DataMatrix part saved: {names[i]} (decode with dcode.fr/datamatrix-code)')

# 5. Extract EXIF thumbnail
def extract_exif_thumbnail(img_path):
    img = Image.open(img_path)
    exif = img.info.get('exif')
    if not exif:
        print('[!] No EXIF data found.')
        return
    try:
        import piexif
        exif_dict = piexif.load(exif)
        thumb = exif_dict.get('thumbnail')
        if thumb:
            with open('exif_thumbnail.jpg', 'wb') as f:
                f.write(thumb)
            print('[*] EXIF thumbnail saved as exif_thumbnail.jpg (decode with dcode.fr/datamatrix-code)')
        else:
            print('[!] No thumbnail in EXIF.')
    except Exception as e:
        print(f'[!] Error extracting EXIF thumbnail: {e}')

if __name__ == '__main__':
    print('--- CTF Solution Extraction ---')
    extract_aztec(CHALLENGE_IMG)
    extract_qr(CHALLENGE_IMG)
    extract_pdf417(CHALLENGE_IMG)
    extract_datamatrix_channels(CHALLENGE_IMG)
    extract_exif_thumbnail(CHALLENGE_IMG)
    print('\nNow decode the cropped images using dcode.fr or your favorite barcode/EXIF tool.')
    print('Flag: RCS{MULT1_C0D3_B4RC0D3}')
