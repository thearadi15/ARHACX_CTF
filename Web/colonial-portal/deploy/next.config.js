/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  // Required for Cloudflare Pages deployment
  output: 'standalone',
  // Disable image optimization for Cloudflare (uses different approach)
  images: {
    unoptimized: true,
  },
}

module.exports = nextConfig
