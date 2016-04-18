<?php
namespace goreilly\WebConnectorExample\Handler;

use goreilly\WebConnector\HandlerInterface;

class ItemHandler implements HandlerInterface
{

    /**
     * We only want ItemQuery Results
     * @param string $type
     * @return bool
     */
    public function supports($type)
    {
        return $type === 'ItemQueryRs';
    }

    /**
     * Log Each Service Item to a file.
     * @param \SimpleXMLElement $element
     * @throws \Exception
     */
    public function handle(\SimpleXMLElement $element)
    {
        $path = __DIR__.'/../log.txt';
        $log = fopen($path, 'w+');
        if ($log === false) {
            throw new \Exception("Failed to open $path for writing");
        }

        fputcsv($log, ['FullName', 'ListID', 'TimeModified']);
        foreach ($element->ItemServiceRet as $service) {
            fputcsv($log, [
                $service->FullName,
                $service->ListID,
                $service->TimeModified,
            ]);
        }

        fclose($log);
    }
}