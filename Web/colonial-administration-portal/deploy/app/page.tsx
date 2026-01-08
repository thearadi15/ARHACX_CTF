'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';

export default function Home() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const router = useRouter();

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      const res = await fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password }),
      });

      const data = await res.json();

      if (res.ok) {
        router.push('/dashboard');
      } else {
        setError(data.error || 'Login failed');
      }
    } catch (err) {
      setError('Network error');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div style={styles.container}>
      <div style={styles.header}>
        <h1 style={styles.title}>🏛️ Colonial Administration Portal</h1>
        <p style={styles.subtitle}>British India Governance System • Est. 1858</p>
      </div>

      <div style={styles.loginBox}>
        <h2 style={styles.loginTitle}>Officer Login</h2>
        <p style={styles.notice}>Authorized Personnel Only</p>

        <form onSubmit={handleLogin}>
          <div style={styles.formGroup}>
            <label style={styles.label}>Username</label>
            <input
              type="text"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              style={styles.input}
              placeholder="Enter your username"
              required
            />
          </div>

          <div style={styles.formGroup}>
            <label style={styles.label}>Password</label>
            <input
              type="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              style={styles.input}
              placeholder="Enter your password"
              required
            />
          </div>

          {error && <p style={styles.error}>{error}</p>}

          <button type="submit" style={styles.button} disabled={loading}>
            {loading ? 'Authenticating...' : 'Login'}
          </button>
        </form>

        <div style={styles.credentials}>
          <p style={styles.credTitle}>Test Credentials:</p>
          <div style={styles.credItem}>
            <strong>Clerk:</strong> clerk_rajesh / clerk123
          </div>
          <div style={styles.credItem}>
            <strong>Officer:</strong> officer_sharma / officer456
          </div>
          <div style={styles.credSmall}>
            (Administrator credentials are classified)
          </div>
        </div>
      </div>

      <div style={styles.footer}>
        <p>Crown Records Management System</p>
        <p style={styles.footerSmall}>For official colonial administration use only</p>
      </div>
    </div>
  );
}

const styles = {
  container: {
    minHeight: '100vh',
    background: 'linear-gradient(135deg, #2c1810 0%, #4a2c1a 100%)',
    display: 'flex',
    flexDirection: 'column' as const,
    alignItems: 'center',
    justifyContent: 'center',
    padding: '20px',
    fontFamily: 'Georgia, serif',
  },
  header: {
    textAlign: 'center' as const,
    marginBottom: '40px',
    color: '#f4e4d7',
  },
  title: {
    fontSize: '2.5rem',
    marginBottom: '10px',
    textShadow: '2px 2px 4px rgba(0,0,0,0.5)',
  },
  subtitle: {
    fontSize: '1.1rem',
    opacity: 0.9,
    letterSpacing: '2px',
  },
  loginBox: {
    background: 'rgba(244, 228, 215, 0.95)',
    padding: '40px',
    borderRadius: '10px',
    boxShadow: '0 10px 40px rgba(0,0,0,0.5)',
    width: '100%',
    maxWidth: '450px',
    border: '3px solid #8b4513',
  },
  loginTitle: {
    textAlign: 'center' as const,
    color: '#2c1810',
    marginBottom: '10px',
    fontSize: '1.8rem',
  },
  notice: {
    textAlign: 'center' as const,
    color: '#8b0000',
    fontSize: '0.9rem',
    marginBottom: '25px',
    fontWeight: 'bold' as const,
  },
  formGroup: {
    marginBottom: '20px',
  },
  label: {
    display: 'block',
    marginBottom: '8px',
    color: '#2c1810',
    fontWeight: 'bold' as const,
  },
  input: {
    width: '100%',
    padding: '12px',
    border: '2px solid #8b4513',
    borderRadius: '5px',
    fontSize: '1rem',
    boxSizing: 'border-box' as const,
    background: '#fff',
  },
  button: {
    width: '100%',
    padding: '14px',
    background: '#8b4513',
    color: 'white',
    border: 'none',
    borderRadius: '5px',
    fontSize: '1.1rem',
    fontWeight: 'bold' as const,
    cursor: 'pointer',
    transition: 'background 0.3s',
  },
  error: {
    color: '#8b0000',
    textAlign: 'center' as const,
    marginBottom: '15px',
    padding: '10px',
    background: '#ffebee',
    borderRadius: '5px',
    border: '1px solid #8b0000',
  },
  credentials: {
    marginTop: '30px',
    padding: '15px',
    background: 'rgba(139, 69, 19, 0.1)',
    borderRadius: '5px',
    fontSize: '0.9rem',
  },
  credTitle: {
    fontWeight: 'bold' as const,
    marginBottom: '10px',
    color: '#2c1810',
  },
  credItem: {
    marginBottom: '8px',
    color: '#2c1810',
  },
  credSmall: {
    fontSize: '0.8rem',
    color: '#666',
    fontStyle: 'italic' as const,
    marginTop: '10px',
  },
  footer: {
    marginTop: '40px',
    textAlign: 'center' as const,
    color: '#f4e4d7',
    opacity: 0.8,
  },
  footerSmall: {
    fontSize: '0.8rem',
    marginTop: '5px',
  },
};
