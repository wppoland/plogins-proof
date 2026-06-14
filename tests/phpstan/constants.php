<?php
/**
 * Constants needed by PHPStan to analyse the plugin without bootstrapping WordPress.
 *
 * @package Proof
 */

declare(strict_types=1);

namespace {
    if (! defined('ABSPATH')) {
        define('ABSPATH', '/tmp/wordpress/');
    }
    if (! defined('PROOF_DIR')) {
        define('PROOF_DIR', '/tmp/proof/');
    }
    if (! defined('PROOF_URL')) {
        define('PROOF_URL', 'http://example.test/wp-content/plugins/proof/');
    }
    // WC_VERSION is provided by the WooCommerce stubs bootstrap file.
}

namespace Proof {
    if (! defined('Proof\\VERSION')) {
        define('Proof\\VERSION', '0.1.0');
    }
    if (! defined('Proof\\PLUGIN_FILE')) {
        define('Proof\\PLUGIN_FILE', '/tmp/proof/proof.php');
    }
}
