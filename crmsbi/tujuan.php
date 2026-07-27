<?php
/**
 * Modernized Port Destination Formatter
 * Original Developer: Irfan Arisaldy (2018)
 * Modernized: PSR-12 & Functional Array Processing
 */

declare(strict_types=1);

/**
 * Format a list of destination ports into a unique, clean comma-separated string.
 *
 * @param string $rawDestinations Raw comma-separated string of ports.
 * @return string Cleaned unique port list.
 */
function formatDestinationPorts(string $rawDestinations): string
{
    $ports = array_map('trim', explode(',', $rawDestinations));
    $uniquePorts = array_values(array_unique(array_filter($ports)));
    
    return implode(', ', $uniquePorts);
}

// Example Execution
$sampleData = 'PELABUHAN TANJUNG PRIOK,PELABUHAN CIWANDAN,PELABUHAN TANJUNG PRIOK,PELABUHAN TANJUNG PRIOK,PELABUHAN TANJUNG PRIOK';
echo formatDestinationPorts($sampleData);
