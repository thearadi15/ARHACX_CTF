'use client';

import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react';

export default function Dashboard() {
  const router = useRouter();
  const [loading, setLoading] = useState(false);

  const handleLogout = async () => {
    await fetch('/api/auth/logout', { method: 'POST' });
    router.push('/');
  };

  return (
    <div style={styles.container}>
      <div style={styles.header}>
        <h1 style={styles.title}>📋 Officer Dashboard</h1>
        <button onClick={handleLogout} style={styles.logoutBtn}>
          Logout
        </button>
      </div>

      <div style={styles.content}>
        <div style={styles.section}>
          <h2 style={styles.sectionTitle}>Available Modules</h2>
          
          <div style={styles.moduleGrid}>
            <div style={styles.module}>
              <h3>👥 Freedom Fighters Database</h3>
              <p>Access records of individuals under surveillance</p>
              <p style={styles.moduleHint}>
                API: GET /api/freedom-fighters/[id]
              </p>
              <div style={styles.exampleIds}>
                Try IDs: 1, 2, 3, 4, 5, ...
              </div>
            </div>

            <div style={styles.module}>
              <h3>🔒 Classified Documents</h3>
              <p>Restricted colonial administration files</p>
              <p style={styles.moduleHint}>
                API: GET /api/classified/constitution-draft
              </p>
              <div style={styles.restricted}>
                ⚠️ Requires Administrator Access
              </div>
            </div>

            <div style={styles.module}>
              <h3>📊 Intelligence Reports</h3>
              <p>Regional surveillance and monitoring data</p>
              <p style={styles.moduleHint}>
                API: GET /api/classified
              </p>
            </div>
          </div>
        </div>

        <div style={styles.hints}>
          <h3 style={styles.hintsTitle}>🔍 Investigation Notes</h3>
          <ul style={styles.hintsList}>
            <li>The freedom fighters database contains sensitive information</li>
            <li>Some records require higher clearance levels</li>
            <li>JWT tokens are used for authentication</li>
            <li>Administrator access unlocks classified documents</li>
            <li>The constitution draft is kept in the most secure vault</li>
          </ul>
        </div>
      </div>
    </div>
  );
}

const styles = {
  container: {
    minHeight: '100vh',
    background: 'linear-gradient(135deg, #1a1a2e 0%, #16213e 100%)',
    padding: '20px',
    fontFamily: 'Georgia, serif',
  },
  header: {
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: '40px',
    padding: '20px',
    background: 'rgba(244, 228, 215, 0.1)',
    borderRadius: '10px',
  },
  title: {
    color: '#f4e4d7',
    fontSize: '2rem',
  },
  logoutBtn: {
    padding: '10px 20px',
    background: '#8b0000',
    color: 'white',
    border: 'none',
    borderRadius: '5px',
    cursor: 'pointer',
    fontSize: '1rem',
    fontWeight: 'bold' as const,
  },
  content: {
    maxWidth: '1200px',
    margin: '0 auto',
  },
  section: {
    marginBottom: '40px',
  },
  sectionTitle: {
    color: '#f4e4d7',
    marginBottom: '20px',
    fontSize: '1.5rem',
  },
  moduleGrid: {
    display: 'grid',
    gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))',
    gap: '20px',
  },
  module: {
    background: 'rgba(244, 228, 215, 0.95)',
    padding: '25px',
    borderRadius: '10px',
    border: '2px solid #8b4513',
  },
  moduleHint: {
    marginTop: '10px',
    fontSize: '0.85rem',
    color: '#666',
    fontFamily: 'monospace',
    background: '#f0f0f0',
    padding: '5px',
    borderRadius: '3px',
  },
  exampleIds: {
    marginTop: '10px',
    fontSize: '0.9rem',
    color: '#2c5282',
    fontStyle: 'italic' as const,
  },
  restricted: {
    marginTop: '10px',
    padding: '8px',
    background: '#ffebee',
    color: '#8b0000',
    borderRadius: '5px',
    fontWeight: 'bold' as const,
    textAlign: 'center' as const,
  },
  hints: {
    background: 'rgba(139, 69, 19, 0.2)',
    padding: '25px',
    borderRadius: '10px',
    border: '2px solid #8b4513',
  },
  hintsTitle: {
    color: '#f4e4d7',
    marginBottom: '15px',
  },
  hintsList: {
    color: '#f4e4d7',
    paddingLeft: '25px',
    lineHeight: '1.8',
  },
};
