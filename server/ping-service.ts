import axios from 'axios';

const PING_INTERVAL = 5 * 60 * 1000; // 5 minutes
const BASE_URL = process.env.APP_URL || `http://0.0.0.0:${process.env.PORT || 3000}`;

export function startPingService() {
  // Initial ping
  ping();

  // Schedule regular pings
  setInterval(ping, PING_INTERVAL);
}

async function ping() {
  try {
    const response = await axios.get(`${BASE_URL}/health`);
    if (response.status === 200) {
      console.log('[PING] Application is healthy');
    }
  } catch (error: any) {
    console.error('[PING] Failed to ping application:', error.message);
  }
}