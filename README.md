# AMCP PHP Client

A PHP client library for the AMCP (Advanced Media Control Protocol) used to control CasparCG Server - a professional graphics and video play-out software.

## Overview

This library provides a simple and intuitive PHP wrapper for communicating with CasparCG Server via the AMCP protocol. It allows you to control video playback, graphics rendering, and other broadcast operations from your PHP applications.

## Features

- **Full AMCP Protocol Support**: Comprehensive command coverage for CasparCG control
- **Object-Oriented API**: Clean and intuitive interface
- **Type-Safe**: Proper typing for better IDE support and fewer errors
- **Easy Integration**: Simple Composer installation
- **Well Tested**: Includes comprehensive test coverage
- **Production Ready**: Battle-tested in real broadcast environments

## Prerequisites

- PHP 7.4 or later
- Composer
- CasparCG Server 2.x or 3.x

## Installation

Install via Composer:

```bash
composer require stukenov/amcp-php-client
```

Or add to your `composer.json`:

```json
{
    "require": {
        "stukenov/amcp-php-client": "^1.0"
    }
}
```

## Quick Start

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Stukenov\AmcpClient\AmcpClient;

// Connect to CasparCG Server
$client = new AmcpClient('localhost', 5250);

// Play a video on channel 1, layer 10
$client->play(1, 10, 'path/to/video');

// Stop playback
$client->stop(1, 10);

// Load a template
$client->cgAdd(1, 10, 'template_name', true, '<templateData></templateData>');
```

## Supported Commands

### Playback Control

- `play()` - Start playing a media file or stream
- `stop()` - Stop playback on a layer
- `pause()` - Pause playback
- `resume()` - Resume paused playback
- `load()` - Load media without playing
- `loadbg()` - Load media in background

### Graphics (CG)

- `cgAdd()` - Add a template to a layer
- `cgPlay()` - Start playing a template
- `cgStop()` - Stop a template
- `cgNext()` - Move to next template element
- `cgUpdate()` - Update template data
- `cgInvoke()` - Invoke template function
- `cgRemove()` - Remove template from layer

### Channel Operations

- `clear()` - Clear all layers on a channel
- `swap()` - Swap content between layers
- `mixer()` - Control mixer operations (volume, keying, etc.)

### Query Commands

- `info()` - Get server information
- `infoChannel()` - Get channel status
- `infoLayer()` - Get layer status
- `cls()` - List available media files
- `tls()` - List available templates
- `version()` - Get server version

## Usage Examples

### Playing Video with Transition

```php
$client = new AmcpClient('localhost', 5250);

// Play with a mix transition over 25 frames
$client->play(1, 10, 'video/clip', true, 'MIX', 25);
```

### Template Graphics

```php
// Add and play a lower third template
$templateData = '<componentData><data id="text" value="John Doe"></data></componentData>';
$client->cgAdd(1, 20, 'lower-third', true, $templateData);

// Update template data
$newData = '<componentData><data id="text" value="Jane Smith"></data></componentData>';
$client->cgUpdate(1, 20, $newData);

// Remove template
$client->cgRemove(1, 20);
```

### Mixer Operations

```php
// Set layer opacity
$client->mixer(1, 10, 'opacity', 0.5);

// Set layer volume
$client->mixer(1, 10, 'volume', 0.7);

// Fill/position adjustment
$client->mixer(1, 10, 'fill', 0.25, 0.25, 0.5, 0.5);
```

### Query Server Status

```php
// Get server info
$info = $client->info();
print_r($info);

// Get channel status
$channelInfo = $client->infoChannel(1);
print_r($channelInfo);

// List available media
$mediaList = $client->cls();
print_r($mediaList);
```

## Advanced Usage

### Custom Timeout

```php
$client = new AmcpClient('localhost', 5250, [
    'timeout' => 5.0  // 5 seconds timeout
]);
```

### Error Handling

```php
try {
    $response = $client->play(1, 10, 'nonexistent/file');
    if (!$response->isSuccess()) {
        echo "Error: " . $response->getMessage();
    }
} catch (\Exception $e) {
    echo "Connection error: " . $e->getMessage();
}
```

### Batch Commands

```php
// Execute multiple commands efficiently
$client->loadbg(1, 10, 'video1');
$client->loadbg(1, 11, 'video2');
$client->loadbg(1, 12, 'video3');

// Start all at once
$client->play(1, 10);
$client->play(1, 11);
$client->play(1, 12);
```

## CasparCG Configuration

Ensure your CasparCG Server is configured to accept AMCP connections. In `casparcg.config`:

```xml
<controller>
    <tcp>
        <port>5250</port>
        <protocol>AMCP</protocol>
    </tcp>
</controller>
```

## Testing

Run the test suite:

```bash
composer test
```

## Architecture

The library follows a simple architecture:

```
AmcpClient
    ├── Connection handling (TCP socket)
    ├── Command building and sending
    ├── Response parsing
    └── Error handling
```

## AMCP Protocol Reference

This library implements AMCP 2.1 protocol. Key concepts:

- **Channels**: Represent output destinations (1-based indexing)
- **Layers**: Multiple layers per channel for composition (0-based or 1-based)
- **Commands**: Text-based protocol commands
- **Responses**: Status codes (200, 201, 400, 404, etc.)

## Performance Considerations

- Connection pooling: Reuse `AmcpClient` instances
- Asynchronous operations: Commands are synchronous; consider queuing for high-volume scenarios
- Network latency: AMCP is TCP-based; minimize round trips

## Troubleshooting

### Connection Refused

- Check CasparCG Server is running
- Verify AMCP port (default 5250)
- Check firewall settings

### Commands Not Working

- Verify CasparCG version compatibility
- Check command syntax in CasparCG documentation
- Enable debug logging in CasparCG

### Media Not Playing

- Verify media paths in CasparCG media folder
- Check file format compatibility
- Use `cls()` to list available media

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Write tests for new features
4. Ensure all tests pass
5. Submit a pull request

## License

MIT License - see LICENSE file for details.

Copyright (c) 2025 Saken Tukenov

## Related Projects

- [CasparCG Server](https://github.com/CasparCG/server) - The broadcast graphics server
- [CasparCG Client](https://github.com/CasparCG/client) - Official CasparCG GUI client

## References

- [AMCP Protocol Documentation](https://github.com/CasparCG/help/wiki/AMCP-Protocol)
- [CasparCG Documentation](https://github.com/CasparCG/help/wiki)

## Support

For issues and questions:
- GitHub Issues: https://github.com/stukenov/amcp-php-client/issues
- CasparCG Forum: https://casparcg.com/forum/
