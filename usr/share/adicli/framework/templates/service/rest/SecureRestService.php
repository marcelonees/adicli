<?php

use Adianti\Service\AdiantiSecureRecordService;

/**
 * {ACTIVE_RECORD}RestService REST service
 */
class {ACTIVE_RECORD}RestService extends AdiantiSecureRecordService
{
    const DATABASE      = '{DATABASE}';
    const ACTIVE_RECORD = '{ACTIVE_RECORD}';

    // Defina as permissões por recurso/método
    const ALLOWED_METHODS = ['GET', 'POST', 'PUT', 'DELETE'];

    // Limite máximo de registros por requisição (0 para infinito)
    const MAX_LIMIT = 20;

    // O método de upload está disponível?
    const UPLOAD_AVAILABLE = false;

    // Extensões de arquivos permitidas
    const VALID_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'bmp',
        'tiff',
        'webp',
        'pdf'
    ];
}
