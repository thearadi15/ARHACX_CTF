// Mock database - In-memory storage for CTF
export interface User {
  id: number;
  username: string;
  password: string; // bcrypt hashed
  role: string;
  department: string;
}

export interface FreedomFighter {
  id: number;
  name: string;
  alias: string;
  location: string;
  threat_level: string;
  notes: string;
  accessible_by_role?: string;
}

// Users database
export const users: User[] = [
  {
    id: 1,
    username: "clerk_rajesh",
    password: "$2a$10$./E4i3t/wRQzwnPb2Pb0NupM1XP0d3leEuFmlYAE6bTR1OEVNqgmi", // password: clerk123
    role: "clerk",
    department: "Revenue"
  },
  {
    id: 2,
    username: "officer_sharma",
    password: "$2a$10$lF462V5B4MN40.FiEAhhb.hsrzHnXWNncaCnucgqIdDjtKavFt7ta", // password: officer456
    role: "officer",
    department: "Intelligence"
  },
  {
    id: 3,
    username: "admin_colonial",
    password: "$2a$10$BptyQwT9WeLNcBs8PDnuneDZL4ZMoYE.nlQhpDxnNE2p0NTafHNqK", // password: BritishRaj@1947
    role: "administrator",
    department: "High Command"
  }
];

// Freedom fighters database
export const freedomFighters: FreedomFighter[] = [
  {
    id: 1,
    name: "Subhash Chandra Bose",
    alias: "Netaji",
    location: "Unknown",
    threat_level: "EXTREME",
    notes: "Leader of INA. Declared most wanted. Armed rebellion.",
    accessible_by_role: "officer"
  },
  {
    id: 2,
    name: "Bhagat Singh",
    alias: "The Revolutionary",
    location: "Punjab Region",
    threat_level: "HIGH",
    notes: "Youth leader. Socialist revolutionary. Executed 1931.",
    accessible_by_role: "officer"
  },
  {
    id: 3,
    name: "Chandrasekhar Azad",
    alias: "Azad",
    location: "Central Provinces",
    threat_level: "HIGH",
    notes: "Never captured alive. Leader of HSRA.",
    accessible_by_role: "officer"
  },
  {
    id: 4,
    name: "Rani Lakshmibai",
    alias: "Rani of Jhansi",
    location: "Jhansi (Historical)",
    threat_level: "LEGENDARY",
    notes: "1857 rebellion leader. Symbol of resistance.",
    accessible_by_role: "clerk"
  },
  {
    id: 5,
    name: "Mohandas Gandhi",
    alias: "Mahatma",
    location: "Sabarmati Ashram",
    threat_level: "MODERATE (Non-violent)",
    notes: "Civil disobedience leader. Mass mobilization capability.",
    accessible_by_role: "clerk"
  },
  {
    id: 99,
    name: "████ ████████",
    alias: "The Architect",
    location: "REDACTED",
    threat_level: "CLASSIFIED",
    notes: "CTF{BR1T15H_3MP1R3_N3V3R_5ET5_0N_FR33D0M}",
    accessible_by_role: "administrator"
  }
];

export function getUserByUsername(username: string): User | undefined {
  return users.find(u => u.username === username);
}

export function getUserById(id: number): User | undefined {
  return users.find(u => u.id === id);
}

export function getFreedomFighterById(id: number): FreedomFighter | undefined {
  return freedomFighters.find(f => f.id === id);
}
