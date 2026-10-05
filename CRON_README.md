# Cron Job: Order Auto-Expiry

**File:** `e-learning-external/app/Controllers/Cron/OrderExpiry.php`
**Route:** `GET /cron/order-expiry`
**Auth:** Bearer token via `CRON_SECRET_KEY` di `.env`

## Alur Kerja

```
[Cron Scheduler] -- GET /cron/order-expiry (Authorization: Bearer <key>)
    --> e-learning-external (OrderExpiry::run)
        --> POST http://internal/api/transactions/auto-expire
            --> MySQL: UPDATE orders SET status='expired'
                       WHERE status='pending' AND created_at < NOW() - INTERVAL 1 HOUR
        <-- { expired_count: N }
    --> Log ditulis ke: e-learning-external/writable/logs/cron-order-expiry.log
<-- { success: true, expired_count: N }
```

## Cara Menjalankan

### Lokal (Manual Test via curl)
```bash
curl -s -H "Authorization: Bearer edunusa-cron-s3cr3t-k3y-2026" \
  http://localhost/cron/order-expiry
```

### Di dalam Docker (dari container external)
```bash
curl -s -H "Authorization: Bearer edunusa-cron-s3cr3t-k3y-2026" \
  http://external/cron/order-expiry
```

### Linux / Production (crontab -e)
```cron
# Jalankan setiap 5 menit untuk expire pesanan yang sudah > 1 jam
*/5 * * * * curl -s -H "Authorization: Bearer edunusa-cron-s3cr3t-k3y-2026" http://external/cron/order-expiry >> /var/log/cron-expire.log 2>&1
```

### Windows Task Scheduler (Lokal Dev)
1. Buka **Task Scheduler** → **Create Basic Task**
2. Trigger: **Daily**, ulangi setiap **5 menit**
3. Action: **Start a program**
   - Program: `curl`
   - Arguments: `-s -H "Authorization: Bearer edunusa-cron-s3cr3t-k3y-2026" http://localhost/cron/order-expiry`

## Keamanan
- Endpoint dilindungi **Bearer token** (`CRON_SECRET_KEY` di `.env`)
- Token default development: `edunusa-cron-s3cr3t-k3y-2026`
- **WAJIB ganti** dengan key yang lebih kuat di production
- Bukan endpoint publik — hanya dipanggil oleh sistem penjadwal

## Log
Hasil eksekusi dicatat di:
```
e-learning-external/writable/logs/cron-order-expiry.log
```
Format: `[2026-09-29 17:30:00] [CRON:OrderExpiry] Status=200 | Expired=3 | Msg=...`
