# Colonial Administration Portal - Deployment Guide

## Deployment Instructions

### Prerequisites
- Node.js 18 or higher
- npm or yarn

### Quick Deploy

```bash
cd deploy
npm install
npm run build
npm start
```

The application will run on `http://localhost:3000`

### Environment Variables

Create `.env.local` file (already included):
```
JWT_SECRET=colonial1947
NODE_ENV=production
```

**⚠️ SECURITY NOTE:** This is an intentionally vulnerable application for CTF purposes. The JWT secret is weak by design.

### Docker Deployment

```dockerfile
FROM node:18-alpine
WORKDIR /app
COPY package*.json ./
RUN npm ci --only=production
COPY . .
RUN npm run build
EXPOSE 3000
CMD ["npm", "start"]
```

Build and run:
```bash
docker build -t colonial-ctf .
docker run -p 3000:3000 colonial-ctf
```

### Cloud Deployment Options

**Vercel (Recommended):**
```bash
npm i -g vercel
vercel --prod
```

**Railway.app:**
- Push to GitHub
- Connect repository at railway.app
- Auto-deploys

**Render.com:**
- New Web Service
- Connect GitHub repository
- Build command: `npm run build`
- Start command: `npm start`

### Production Checklist

- [ ] Application runs on port 3000
- [ ] JWT secret is set to `colonial1947`
- [ ] Login works with test credentials
- [ ] `/api/classified/constitution-draft` is accessible (after exploit)
- [ ] No build errors in logs

### Test Credentials

Displayed on login page:
- **Clerk:** `clerk_rajesh` / `clerk123`
- **Officer:** `officer_sharma` / `officer456`

### Monitoring

Monitor for:
- Successful logins
- JWT token manipulation attempts
- Access to classified endpoints
- IDOR enumeration on `/api/freedom-fighters/`

### Troubleshooting

**Port already in use:**
```bash
npm run dev -- -p 3001
```

**Build fails:**
```bash
rm -rf .next node_modules
npm install
npm run build
```

---

## Security Notes

This is an **intentionally vulnerable application** for CTF challenges. Do not:
- Deploy on public production systems
- Use in real applications
- Reuse any code patterns

The application contains:
- JWT alg=none vulnerability
- Weak JWT secret
- Authorization bypass flaws
- IDOR vulnerabilities

All vulnerabilities are intentional for educational purposes.
