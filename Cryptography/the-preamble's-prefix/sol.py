import hashlib

# 1. The salts extracted from preamble.jpg metadata
salts = ["JUSTICE", "LIBERTY", "EQUALITY", "FRATERNITY"]

# 2. The hashes extracted from national_archive.pcap
target_hashes = [
"92a5cb9d98ca27b1d199528ba8312440cdff780a22ee1de8a10300819a8efda6",
"811499811e9ca54495678d74e272926953663fe87963afc5f3293b03befc6689",
"6231023e206f12de33a7eec583b37ba1a36b216bcb1731f7199461e16cd7a8c0",
"29f66ebbc98bcaa1a6daadcb8512e97e0745300ce5500cbf571019053e58cfb6"
]

# 3. Load the wordlist
with open("founding_principles.txt", "r") as f:
    words = [line.strip() for line in f]

flag_parts = []

print("[*] Cracking Republic signatures...")

# 4. The Cracking Loop
for i, salt in enumerate(salts):
    found = False
    for word in words:
        # The rule: Salt + Word
        attempt = salt + word
        attempt_hash = hashlib.sha256(attempt.encode()).hexdigest()
        
        if attempt_hash == target_hashes[i]:
            print(f"[+] Match found for {salt}: {word}")
            flag_parts.append(word.capitalize())
            found = True
            break
    if not found:
        print(f"[!] Failed to crack {salt}")

# 5. Final Flag Assembly
if len(flag_parts) == 4:
    flag = f"RCS{{{'_'.join(flag_parts)}}}"
    print(f"\nFINAL FLAG: {flag}")
