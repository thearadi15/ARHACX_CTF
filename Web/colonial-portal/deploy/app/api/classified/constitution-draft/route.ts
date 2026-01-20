import { NextRequest, NextResponse } from 'next/server';

export const runtime = 'edge';

// THE FLAG ENDPOINT - Administrator only
export async function GET(request: NextRequest) {
  const userRole = request.headers.get('x-user-role');
  const userDept = request.headers.get('x-user-dept');

  // This endpoint is protected by middleware
  // But can be bypassed with JWT manipulation

  if (userRole !== 'administrator' && userDept !== 'High Command') {
    return NextResponse.json(
      { 
        error: 'CLASSIFIED - Administrator Access Required',
        message: 'This document contains sensitive constitutional drafts from the independence movement.',
        security_note: 'Unauthorized access attempts are logged and reported to the Crown.'
      },
      { status: 403 }
    );
  }

  // THE FLAG
  return NextResponse.json({
    success: true,
    document: 'Constitution Draft - Pre-Independence',
    classification: 'TOP SECRET',
    date: '1947-08-14',
    content: {
      preamble: 'We, the people of India, having solemnly resolved to constitute India into a SOVEREIGN DEMOCRATIC REPUBLIC...',
      flag: 'CTF{C0L0N14L_CH41N5_BR0K3N_FR33D0M_4CH13V3D_1947}',
      note: 'Congratulations! You have successfully exploited:',
      vulnerabilities_exploited: [
        '1. JWT alg=none bypass OR weak secret cracking',
        '2. Middleware role check flaw',
        '3. IDOR on freedom fighters endpoint',
        '4. Authentication token manipulation'
      ],
      historical_note: 'India gained independence on August 15, 1947, breaking free from British colonial rule.',
      credits: 'CTF Challenge: Colonial Administration Portal'
    }
  });
}
