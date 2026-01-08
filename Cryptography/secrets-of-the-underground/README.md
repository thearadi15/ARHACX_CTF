# Secrets of the Underground

**Category:** Cryptography  
**Difficulty:** Hard  
**Points:** 650  

## Story

*August 14, 1947 — One day before independence*

British intelligence has intercepted a critical communication between freedom fighters in the underground resistance. The letter, passed through secret channels, contains vital information about the final push for independence.

Your handler has recovered this encrypted message from a British officer's desk. The revolutionaries used layers of encryption to protect their secrets from colonial surveillance. Intelligence suggests the message contains coordinates and timing for a historic event.

**Your Mission:** Decrypt the multi-layered message and recover the hidden flag.

> *"Ink fades. Codes endure."*  
> — Last words of an unnamed freedom fighter, 1946

## Description

You've intercepted an encrypted letter between Indian revolutionaries operating under British surveillance in 1947. The message uses multiple layers of encryption, each more complex than the last.

The freedom fighters were masters of cryptography, using classical ciphers chained together to protect their secrets. They knew that even if one layer was broken, the British codebreakers would face many more.

Can you decrypt all three layers and recover the final message?

## Files Provided

- `intercepted_letter.txt` — The encrypted message
- `found_poem.txt` — A patriotic poem found with the letter
- `intelligence_brief.txt` — British intelligence notes

## Challenge Layers

**Stage 1:** Caesar cipher with a historical twist  
**Stage 2:** Vigenère cipher with hidden key  
**Stage 3:** RSA encryption with a critical weakness  

## Hints

**Hint 1 (50 points):** The revolutionaries often used significant dates as cipher parameters. What happened in 1947?

**Hint 2 (100 points):** The poem isn't just for inspiration — every first letter tells a story.

**Hint 3 (150 points):** Even the British made mistakes. These RSA primes are suspiciously close to each other...

## Notes

- No brute force required
- Flag format: `CTF{...}`
- Each stage reveals the input for the next
- Historical context is important
- All encryption is breakable with the right approach

## Learning Objectives

- Classical cipher analysis (Caesar, Vigenère)
- Cipher chaining concepts
- Pattern recognition in ciphertexts
- RSA weakness exploitation (Fermat's factorization)
- Cryptanalysis techniques

## Tags

`cryptography` `caesar` `vigenere` `rsa` `cipher-chaining` `classical-crypto` `hard`

## Deployment

- Static challenge (downloadable files only)
- No server required
- All tools needed: Python, basic crypto libraries

---

*Dedicated to the unsung heroes of India's freedom struggle who protected their secrets with ingenuity and courage.*
