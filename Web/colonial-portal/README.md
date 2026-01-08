# Colonial Administration Portal

**Category:** Web  
**Difficulty:** Medium  
**Points:** 400  

## Description
You've discovered an old British colonial administration system from 1947. The portal contains classified documents about India's independence movement, including a secret constitution draft. Your mission is to bypass the authentication system and retrieve the classified documents that only administrators can access.

The system uses JWT-based authentication with role-based access control. Can you elevate your privileges from a clerk to an administrator and access the constitution draft before independence day?

## Files Provided
- Source code (deployed as live web application)
- Test credentials provided on login page

## Deployment
- Hosted as live web application
- Access URL will be provided during CTF
- No VPN required

## Learning Objectives
- JWT authentication vulnerabilities
- Algorithm confusion attacks (alg=none)
- Weak secret exploitation
- Authorization bypass techniques
- IDOR (Insecure Direct Object Reference)

## Notes
- No brute force required
- Flag format: `CTF{...}`
- Multiple solution paths available
- Test credentials are provided on the login page

## Tags
`jwt` `authentication` `authorization` `web` `api-security` `next.js`
