from scapy.all import IP, UDP, DNS, DNSQR, TCP, Raw, Ether, ICMP, wrpcap
import random
import hashlib

# 1. Calculate our 'Republic' Hashes
# JUSTICEsovereign, LIBERTYsocialist, EQUALITYsecular, FRATERNITYdemocratic
pairs = [("JUSTICE", "sovereign"), ("LIBERTY", "socialist"), ("EQUALITY", "secular"), ("FRATERNITY", "democratic")]
challenge_hashes = [hashlib.sha256((s+w).encode()).hexdigest() for s, w in pairs]

packets = []
archive_ip = "192.168.26.1"
sentinel_ip = "192.168.26.100"

# 2. Function to generate noise
def add_noise():
    # Random DNS Noise
    sites = ["pib.gov.in", "mygov.in", "archives.nic.in", "parade.internal"]
    dns_pkt = (Ether()/IP(dst="8.8.8.8")/UDP(dport=53)/
               DNS(rd=1, qd=DNSQR(qname=random.choice(sites))))
    packets.append(dns_pkt)

    # Corrected ICMP "Heartbeat" Noise
    icmp_pkt = (Ether()/IP(src=archive_ip, dst="192.168.26.50")/ICMP())
    packets.append(icmp_pkt)

# 3. Main Loop: Interleave Noise and Challenge
print("[*] Generating Republic Day packets...")
for i, h in enumerate(challenge_hashes):
    # Add 10-15 random noise packets before each hash
    for _ in range(random.randint(10, 15)):
        add_noise()
    
    # Add the Challenge Packet
    challenge_pkt = (Ether()/
                    IP(src=archive_ip, dst=sentinel_ip)/
                    UDP(sport=1950, dport=2026)/
                    Raw(load=f"REPUBLIC_AUTH_SIG_{i+1}:{h}"))
    packets.append(challenge_pkt)
    print(f"[+] Injected Signature Hash {i+1}")

# Add some trailing noise
for _ in range(20):
    add_noise()

# Save the messy PCAP
wrpcap("national_archive_noisy.pcap", packets)
print("\n[!] Success! Created national_archive_noisy.pcap with background noise.")
