#!/usr/bin/env python3
"""
Create 'Code Logistics Hub' CTF Challenge
"""

import os
import numpy as np
from PIL import Image, ImageDraw
import segno
import pdf417
import piexif

def create_challenge():
    print("Creating CTF challenge image...")
    
    # Create base image
    img = Image.new('RGB', (800, 600), color=(240, 240, 240))
    draw = ImageDraw.Draw(img)
    
    # Add title text
    from PIL import ImageFont
    try:
        font = ImageFont.truetype("arial.ttf", 20)
        draw.text((20, 10), "Logistics Hub Inventory - Q4 2024", fill="black", font=font)
    except:
        draw.text((20, 10), "Logistics Hub Inventory - Q4 2024", fill="black")
    
    # 1. Add Aztec Code
    print("  Adding Aztec code...")
    aztec = segno.make("Pattern below: access strip w/ pass", micro=False)
    aztec.save('temp_aztec.png', scale=4)
    aztec_img = Image.open('temp_aztec.png').resize((60, 60))
    img.paste(aztec_img, (30, 30))
    
    # 2. Add Red Herring QR
    print("  Adding QR code (red herring)...")
    qr = segno.make_qr("Ignore me, check the corners")
    qr.save('temp_qr.png', scale=6)
    qr_img = Image.open('temp_qr.png').resize((180, 180))
    img.paste(qr_img, (310, 210))
    
    # 3. Add MaxiCode-like pattern
    print("  Creating MaxiCode background pattern...")
    for x in range(0, 800, 25):
        for y in range(400, 600, 25):
            draw.ellipse([x+5, y+5, x+20, y+20], outline='#CCCCCC', width=1)
            if ((x//25 + y//25) % 3 == 0):
                draw.ellipse([x+11, y+11, x+14, y+14], fill='#666666')
    
    # 4. Add "damaged" PDF417
    print("  Adding PDF417 barcode...")
    data = "Password: SH1PP1NG_L0G5"
    codes = pdf417.encode(data, columns=2)
    pdf_img_obj = pdf417.render_image(codes, scale=3)
    pdf_img_obj.save("temp_pdf417.png")
    pdf_img = Image.open("temp_pdf417.png").rotate(90, expand=True)
    pdf_img = pdf_img.resize((500, 60))
    
    # Add noise to make it look damaged
    noise = np.random.randint(0, 60, (60, 500, 3), dtype=np.uint8)
    noise_img = Image.fromarray(noise, 'RGB')
    pdf_img = Image.blend(pdf_img.convert('RGB'), noise_img, alpha=0.4)
    img.paste(pdf_img, (150, 550))
    
    # 5. Hide DataMatrix in channels
    print("  Hiding DataMatrix in color channels...")
    from pylibdmtx.pylibdmtx import encode
    dm_parts = ['RCS{MULT1', '_C0D3_', 'B4RC0D3}']
    img_array = np.array(img)
    positions = [(600, 50), (650, 250), (700, 450)]
    channels = [2, 1, 0]  # 2=blue, 1=green, 0=red
    for i, part in enumerate(dm_parts):
        encoded = encode(part.encode('utf-8'))
        dm_img = Image.frombytes('RGB', (encoded.width, encoded.height), encoded.pixels).convert('L').resize((80, 80))
        dm_array = np.array(dm_img)
        x, y = positions[i]
        channel = channels[i]
        img_array[y:y+80, x:x+80, channel] = np.where(
            dm_array < 128,
            img_array[y:y+80, x:x+80, channel] - 30,
            img_array[y:y+80, x:x+80, channel] + 30
        )
    img = Image.fromarray(img_array)
    
    # 6. Add EXIF with thumbnail
    print("  Adding EXIF thumbnail...")
    # Create DataMatrix thumbnail using pylibdmtx
    encoded_thumb = encode('RCS{MULT1'.encode('utf-8'))
    thumb_img = Image.frombytes('RGB', (encoded_thumb.width, encoded_thumb.height), encoded_thumb.pixels).convert('RGB').resize((64, 64))
    thumb_img.save('temp_thumbnail.jpg')
    with open('temp_thumbnail.jpg', 'rb') as f:
        thumb_data = f.read()
    
    exif_dict = {
        "0th": {
            piexif.ImageIFD.Make: b"LogisticsCam",
            piexif.ImageIFD.Software: b"BarcodeSystem v2.4"
        },
        "Exif": {
            piexif.ExifIFD.DateTimeOriginal: b"2024:01:24 15:30:00",
            piexif.ExifIFD.UserComment: b"Check all channels"
        },
        "thumbnail": thumb_data
    }
    
    exif_bytes = piexif.dump(exif_dict)
    
    # Save final image
    print("  Saving final image...")
    img.save('CTF_Code_Logistics_Hub.jpg', exif=exif_bytes, quality=95)
    
    # Cleanup
    print("  Cleaning up temporary files...")
    temp_files = [f for f in os.listdir() if f.startswith('temp_')]
    for file in temp_files:
        os.remove(file)
    
    print("\n✅ Challenge created: 'CTF_Code_Logistics_Hub.jpg'")
    print("\nFlag: RCS{MULT1_C0D3_B4RC0D3}")
    print("\nExpected solution path:")
    print("1. Aztec code → 'MaxiCode in floor reveals PDF417 key'")
    print("2. MaxiCode pattern → Extract to get password hint")
    print("3. PDF417 with password → 'Password: SH1PP1NG_L0G5'")
    print("4. DataMatrix parts in EXIF + channels → Combine for flag")
    
    return "CTF_Code_Logistics_Hub.jpg"

if __name__ == "__main__":
    create_challenge()
