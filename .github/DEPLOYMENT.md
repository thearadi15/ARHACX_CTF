# CTF Challenge Deployment Guide

This repository uses **GitHub Actions** to automatically deploy challenges to **Cloudflare Pages/Workers**.

---

## Table of Contents

- [Quick Start](#-quick-start)
- [How It Works](#-how-it-works)
- [Configuration Reference](#-configuration-reference)
- [Deployment Types](#-deployment-types)
- [Custom Domains](#-custom-domains)
- [Examples](#-examples)
- [Troubleshooting](#-troubleshooting)

---

## Quick Start

### 1. Create `deploy.config.json` in your challenge folder

```json
{
  "$schema": "../../.github/deploy.schema.json",
  "name": "My Challenge",
  "enabled": true,
  "type": "pages",
  "framework": "nextjs",
  "deploy_directory": "deploy",
  "build_command": "npm run build",
  "env": {
    "NODE_ENV": "production"
  }
}
```

### 2. Push your changes

```bash
git add .
git commit -m "Add deployment config for my-challenge"
git push
```

### 3. Check GitHub Actions

The workflow automatically:
- Detects your `deploy.config.json`
- Builds your application
- Deploys to Cloudflare
- Updates your README with the live URL

---

## How It Works

### Trigger Mechanism

The deployment workflow **only triggers** when:
1. A `deploy.config.json` file is **created or modified**
2. The push is to `main` or `master` branch
3. You manually trigger via GitHub Actions UI

### Selective Deployment

- Only challenges with **modified** `deploy.config.json` are deployed
- Other challenges are **not affected**
- Saves resources and deployment time

### Workflow Steps

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│  Detect Changes │ ──▶ │  Build Project  │ ──▶ │ Deploy to CF    │
└─────────────────┘     └─────────────────┘     └─────────────────┘
                                                        │
                                                        ▼
                                               ┌─────────────────┐
                                               │  Update README  │
                                               └─────────────────┘
```

---

## Configuration Reference

### Full `deploy.config.json` Schema

| Property | Type | Required | Default | Description |
|----------|------|----------|---------|-------------|
| `name` | string | No | folder name | Display name for the challenge |
| `enabled` | boolean | **Yes** | `true` | Set to `false` to skip deployment |
| `type` | string | No | `"pages"` | `"pages"` or `"worker"` |
| `framework` | string | No | `"nextjs"` | Framework: `nextjs`, `react`, `vue`, `svelte`, `static`, `node` |
| `deploy_directory` | string | No | `"deploy"` | Folder containing the app |
| `install_command` | string | No | `"npm ci"` | Command to install dependencies |
| `build_command` | string | No | `"npm run build"` | Command to build the app |
| `output_directory` | string | No | `".next"` | Built files directory (for static) |
| `domain` | string | No | - | Custom domain (e.g., `ctf.example.com`) |
| `subdomain` | string | No | - | Subdomain prefix |
| `env` | object | No | `{}` | Environment variables |
| `node_version` | string | No | `"20"` | Node.js version |
| `compatibility_date` | string | No | `"2024-01-01"` | Cloudflare Workers compat date |

---

## Deployment Types

### Cloudflare Pages (Recommended)

Best for:
- Static sites
- Next.js applications
- React/Vue/Svelte apps
- Most web challenges

```json
{
  "type": "pages",
  "framework": "nextjs"
}
```

**Default URL:** `https://<challenge-name>.pages.dev`

### Cloudflare Workers

Best for:
- Serverless APIs
- Custom runtime requirements
- Edge computing challenges

```json
{
  "type": "worker",
  "compatibility_date": "2024-01-01"
}
```

**Default URL:** `https://<challenge-name>.workers.dev`

---

## Custom Domains

### Using Default Cloudflare URLs

If no domain is specified, your challenge will be available at:
- **Pages:** `https://<challenge-name>.pages.dev`
- **Workers:** `https://<challenge-name>.workers.dev`

### Using Custom Domain

1. Add your domain to Cloudflare
2. Configure in `deploy.config.json`:

```json
{
  "domain": "ctf.rcsctf.com",
  "subdomain": "web-challenge"
}
```

**Result:** `https://web-challenge.ctf.rcsctf.com`

### Using Root Domain

```json
{
  "domain": "challenge.rcsctf.com"
}
```

**Result:** `https://challenge.rcsctf.com`

---

## Examples

### Next.js Web Challenge

```json
{
  "$schema": "../../.github/deploy.schema.json",
  "name": "Colonial Portal",
  "enabled": true,
  "type": "pages",
  "framework": "nextjs",
  "deploy_directory": "deploy",
  "build_command": "npm run build",
  "subdomain": "colonial-portal",
  "env": {
    "NODE_ENV": "production",
    "JWT_SECRET": "colonial1947"
  }
}
```

### Static HTML Challenge

```json
{
  "$schema": "../../.github/deploy.schema.json",
  "name": "OSINT Investigation",
  "enabled": true,
  "type": "pages",
  "framework": "static",
  "deploy_directory": "site",
  "output_directory": ".",
  "build_command": "echo 'No build needed'",
  "subdomain": "osint-investigation"
}
```

### React App Challenge

```json
{
  "$schema": "../../.github/deploy.schema.json",
  "name": "React XSS Lab",
  "enabled": true,
  "type": "pages",
  "framework": "react",
  "deploy_directory": "app",
  "build_command": "npm run build",
  "output_directory": "build",
  "subdomain": "xss-lab"
}
```

### API Worker Challenge

```json
{
  "$schema": "../../.github/deploy.schema.json",
  "name": "API Security Challenge",
  "enabled": true,
  "type": "worker",
  "framework": "node",
  "deploy_directory": "api",
  "build_command": "npm run build",
  "compatibility_date": "2024-01-01",
  "subdomain": "api-security"
}
```

---

## Troubleshooting

### Deployment not triggering

- Ensure `deploy.config.json` was modified in the push
- Check you're pushing to `main` or `master` branch

### Build failing

- Check `build_command` is correct
- Verify `deploy_directory` exists
- Ensure all dependencies are in `package.json`
