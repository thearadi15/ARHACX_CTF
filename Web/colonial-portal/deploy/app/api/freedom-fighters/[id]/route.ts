import { NextRequest, NextResponse } from 'next/server';
import { getFreedomFighterById } from '@/lib/db';

// VULNERABILITY 4: IDOR - Insecure Direct Object Reference
export async function GET(
  request: NextRequest,
  { params }: { params: { id: string } }
) {
  try {
    const id = parseInt(params.id);
    
    if (isNaN(id)) {
      return NextResponse.json(
        { error: 'Invalid ID format' },
        { status: 400 }
      );
    }

    // Get user role from middleware-injected header
    const userRole = request.headers.get('x-user-role');

    if (!userRole) {
      return NextResponse.json(
        { error: 'Unauthorized' },
        { status: 401 }
      );
    }

    const fighter = getFreedomFighterById(id);

    if (!fighter) {
      return NextResponse.json(
        { error: 'Freedom fighter record not found' },
        { status: 404 }
      );
    }

    // CRITICAL FLAW: Role check is easily bypassable
    // The check only compares accessible_by_role but:
    // 1. Doesn't properly enforce it
    // 2. Anyone can access if they know the ID
    // 3. The comparison is case-sensitive and can be bypassed
    
    // Weak access control - only shows warning for clerk accessing high records
    if (fighter.accessible_by_role === 'administrator' && userRole === 'clerk') {
      return NextResponse.json(
        { 
          error: 'Access level insufficient',
          hint: 'This record requires elevated privileges. Perhaps check your token claims?'
        },
        { status: 403 }
      );
    }

    // FLAW: Officer can access everything except administrator-level
    // But there's no actual blocking, just a soft check above
    // Anyone with officer or higher role can enumerate all IDs

    return NextResponse.json({
      success: true,
      data: fighter
    });

  } catch (error) {
    return NextResponse.json(
      { error: 'Internal server error' },
      { status: 500 }
    );
  }
}
