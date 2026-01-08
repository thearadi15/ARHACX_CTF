import { NextRequest, NextResponse } from 'next/server';

export async function GET(request: NextRequest) {
  const userRole = request.headers.get('x-user-role');

  return NextResponse.json({
    success: true,
    message: 'Welcome to the Classified Documents Section',
    available_documents: [
      {
        id: 1,
        title: 'Intelligence Reports',
        endpoint: '/api/classified/intelligence-reports',
        status: 'Available'
      },
      {
        id: 2,
        title: 'Constitution Draft',
        endpoint: '/api/classified/constitution-draft',
        status: 'RESTRICTED - Highest Clearance Required',
        hint: 'Only accessible by administrators with High Command clearance'
      }
    ],
    your_role: userRole,
    note: 'Some documents require specific authorization levels'
  });
}
