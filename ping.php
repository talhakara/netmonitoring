<?php
header('Content-Type: application/json');

if (!isset($_GET['ip'])) {
    die(json_encode(['error' => 'IP adresi gerekli']));
}

$ip = $_GET['ip'];

// IP adresini temizle
$ip = filter_var($ip, FILTER_VALIDATE_IP);
if (!$ip) {
    die(json_encode(['error' => 'Geçersiz IP adresi']));
}

// Windows için
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $cmd = "ping -n 1 -w 1000 " . escapeshellarg($ip);
    exec($cmd, $output, $return_var);
    
    if ($return_var === 0) {
        foreach ($output as $line) {
            if (preg_match('/time[=<](\d+)ms/i', $line, $matches)) {
                echo json_encode([
                    'status' => true,
                    'latency' => (int)$matches[1]
                ]);
                exit;
            }
        }
    }
} 
// Linux/Unix için
else {
    $cmd = "ping -c 1 -W 1 " . escapeshellarg($ip);
    exec($cmd, $output, $return_var);
    
    if ($return_var === 0) {
        foreach ($output as $line) {
            if (preg_match('/time=(\d+\.?\d*) ms/i', $line, $matches)) {
                echo json_encode([
                    'status' => true,
                    'latency' => (float)$matches[1]
                ]);
                exit;
            }
        }
    }
}

// Ping başarısız olursa
echo json_encode([
    'status' => false,
    'latency' => null
]);
?> 