# CTF Challenges Repository

This repository contains all challenges for the CTF event.
It is structured to work with **CTFd** while remaining reusable, auditable, and consistent for future events.

---

## Repository Structure

```
CTF/
├── Web/
├── Linux_Privilege_Escalation/
├── Active_Directory/
├── Cryptography/
├── Reverse_Engineering/
├── Forensics/
├── OSINT/
├── Binary_Exploitation/
├── Steganography/
├── Misc/
└── Final_Boss/
```

Each category contains independent challenge folders.

---

## Challenge Folder Standard (Required)

Every challenge must follow this structure:

```
Category/
└── challenge-name/
    ├── README.md
    ├── challenge.json
    ├── attachments/
    ├── deploy/        (optional)
    └── solution/      
```

Rules:

* Folder names must be lowercase and hyphen-separated
* One challenge per folder
* No shared files between challenges

---

## Difficulty Levels

Each challenge must use exactly one difficulty level:

| Difficulty | Description                       |
| ---------- | --------------------------------- |
| Easy       | Beginner level, single concept    |
| Medium     | Requires tooling or chaining      |
| Hard       | Advanced exploitation or analysis |
| Insane     | Multi-stage or research-level     |

---

## Point System (variable)

Use the following point ranges:

| Difficulty | Points     |
| ---------- | ---------- |
| Easy       | 100 – 200  |
| Medium     | 250 – 400  |
| Hard       | 500 – 700  |
| Insane     | 800 – 1200 |

Rules:

* Avoid duplicate point values within the same category
* Final Boss challenges must be 800 points or higher
* Dynamic scoring should only be used with organizer approval

---

## Challenge README.md Template

Each challenge must include a `README.md` using this format:

```md
# Challenge Name

Category: Web  
Difficulty: Medium  
Points: 300  

## Description
Clear description of the objective without spoilers.

## Files Provided
- login.zip
- capture.pcap

## Deployment
- Hosted internally
- Accessible via VPN if required

## Notes
- No brute force required
- Flag format: RCS_CTF{lowercase_alphanumeric_and_underscores}
```

---

## Automatic Deployment (Cloudflare)

Challenges that require web hosting are **automatically deployed** to Cloudflare when you add a `deploy.config.json` file.

### Quick Setup

1. Create `deploy.config.json` in your challenge folder:

```json
{
  "$schema": "../../.github/deploy.schema.json",
  "name": "My Challenge",
  "enabled": true,
  "type": "pages",
  "framework": "nextjs",
  "deploy_directory": "deploy",
  "build_command": "npm run build"
}
```

2. Push to `main` branch - deployment happens automatically!

### Updated Challenge Structure

```
Category/
└── challenge-name/
    ├── README.md           # Auto-updated with deployment URL
    ├── challenge.json
    ├── deploy.config.json  # Triggers deployment
    ├── attachments/
    ├── deploy/
    └── solution/
```

### Key Points

* **Trigger:** Only pushes that modify `deploy.config.json` trigger deployment
* **Selective:** Only changed challenges are deployed (saves resources)
* **Auto-URL:** README is automatically updated with the live URL
* **Platform:** Cloudflare Pages (static/Next.js) or Workers (APIs)

**Full documentation:** [.github/DEPLOYMENT.md](.github/DEPLOYMENT.md)

---

## Flag Rules

* Flag format:

  ```
  RCS_CTF{lowercase_alphanumeric_and_underscores}
  ```

---

## Security and Quality Requirements

All challenges must:

* Be tested by at least one other organizer
* Have no unintended solutions
* Match the intended difficulty
* Not require internet access unless stated
* Be resettable after each solve

---

## Final Boss Challenges

Final Boss challenges:

* Combine multiple categories
* Require prior solves
* Represent the final stage of the CTF

They must be placed in:

```
Final_Boss/
```


