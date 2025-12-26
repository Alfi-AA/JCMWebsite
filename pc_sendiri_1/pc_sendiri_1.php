<?php
echo "<h2>Deteksi Hardware Server</h2>";
echo "<pre>";

echo "=== Sistem Operasi ===\n";
echo php_uname() . "\n\n";

$isWindow = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';


// CPU DETECTION //
echo "=== CPU ===\n";

if ($isWindow) {
    // Gunakan PowerShell 
    $cpu = shell_exec("powershell -command \"(Get-CimInstance Win32_Processor).Name\"");

    if (trim($cpu) !== "") {
        echo "CPU: " . $cpu . "\n";
    } else {
        // Fallback WMIC untuk windows lama 
        $cpu = shell_exec("wmic cpu get Name");
        echo $cpu ? $cpu : "CPU tidak dapat dibaca\n";
    }
} else {
    // Linux / Unix
    $cpuinfo = file_get_contents('/proc/cpuinfo');
    echo $cpuinfo ?: "CPU tidak dapat dibaca\n";
}

echo "\n";

// RAM DETECTION //
echo "=== RAM ===\n";

if ($isWindow) {
    // powershell
    $ram = shell_exec("powershell -command \"(Get-CimInstance Win32_ComputerSystem).TotalPhysicalMemory\"");

    if (trim($ram) !== "") {
        $gb = round($ram / 1024 / 1024 / 1024, 2);
        echo "Total RAM: {$gb} GB\n";
    } else {
        // Fallback WMIC
        $ram = shell_exec("wmic ComputerSystem get TotalPhysicalMemory");
        echo $ram ? $ram : "RAM tidak dapat dibaca\n";  
    } 
} else {
    // Linux / Unix
    $meminfo = file_get_contents('/proc/meminfo');
    echo $meminfo ?: "RAM tidak dapat dibaca\n";
}

echo "\n";

// DISK DETECTION //
echo "=== DISK ===\n";
echo "Total Disk: " . round(disk_total_space("/") / 1024 / 1024 / 1024, 2) . " GB\n";
echo "Free Disk: " . round(disk_free_space("/") / 1024 / 1024 / 1024, 2) . " GB\n";

// PHP // 
echo "PHP Version: " . phpversion() . "\n";

echo "</pre>";
?>