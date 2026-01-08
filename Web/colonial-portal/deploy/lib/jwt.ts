import jwt from 'jsonwebtoken';

const JWT_SECRET = process.env.JWT_SECRET || 'colonial1947';

export interface TokenPayload {
  userId: number;
  username: string;
  role: string;
  department: string;
  iat?: number;
  exp?: number;
}

// VULNERABILITY 1: Accepts alg=none tokens
export function verifyToken(token: string): TokenPayload | null {
  try {
    // First check if it's an alg=none token
    const parts = token.split('.');
    if (parts.length === 3) {
      const header = JSON.parse(Buffer.from(parts[0], 'base64').toString());
      
      // CRITICAL FLAW: Accept alg=none tokens without verification
      if (header.alg === 'none' || header.alg === 'None' || header.alg === 'NONE') {
        const payload = JSON.parse(Buffer.from(parts[1], 'base64').toString());
        return payload as TokenPayload;
      }
    }
    
    // VULNERABILITY 2: Weak secret (colonial1947)
    const decoded = jwt.verify(token, JWT_SECRET) as TokenPayload;
    return decoded;
  } catch (error) {
    return null;
  }
}

export function generateToken(payload: Omit<TokenPayload, 'iat' | 'exp'>): string {
  return jwt.sign(payload, JWT_SECRET, { expiresIn: '24h' });
}

// Helper to create unsigned token (for testing/exploitation)
export function createUnsignedToken(payload: TokenPayload): string {
  const header = { alg: 'none', typ: 'JWT' };
  const encodedHeader = Buffer.from(JSON.stringify(header)).toString('base64url');
  const encodedPayload = Buffer.from(JSON.stringify(payload)).toString('base64url');
  return `${encodedHeader}.${encodedPayload}.`;
}
