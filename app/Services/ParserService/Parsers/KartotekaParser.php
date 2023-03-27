<?php

namespace App\Services\ParserService\Parsers;

use App\Models\Auction;
use App\Models\Lot;
use App\Models\Organizer;
use App\Services\ParserService\DTO\AuctionDTO;
use App\Services\ParserService\ParserInterface;
use Carbon\Carbon;
use DOMElement;
use Exception;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class KartotekaParser implements ParserInterface
{
    private const TABLE_CLASS = 'data';

    private string $url;
    private Crawler $crawler;

    public function __construct()
    {
        $this->crawler = new Crawler();
    }

    /**
     * @param string $url
     * @return $this
     */
    public function initUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param int $page
     * @return array|AuctionDTO[]
     * @throws Exception
     */
    public function parse(int $page): array
    {
        $parseResult = [];

        $htmlData = $this->requestData($page);

        $this->crawler->addHtmlContent($htmlData);
        $this->crawler = $this->crawler->filter('.' . self::TABLE_CLASS . ' > tr');

        $counter = 0;
        foreach ($this->crawler as $rowNode)
        {
            if (++$counter == $this->crawler->count())
                break;

            $parseResult[] = $this->parseRowNode($rowNode);
        }

        return $parseResult;
    }

    /**
     * Запрашивает данные и преобразует их в UTF-8
     *
     * @param int $page
     * @return string
     * @throws Exception
     */
    private function requestData(int $page): string
    {
        if (empty($this->url))
        {
            throw new Exception('Url is empty');
        }

        $urlWithPage = $this->url . ($page > 1 ? "?page=$page" : '');
        $response = Http::get($urlWithPage);
        $responseBody = $response->body();

        if ($response->header('Content-Type') == 'text/html;charset=Windows-1251')
        {
            $responseBody = mb_convert_encoding($responseBody, 'utf-8', 'windows-1251');
        }

        return $responseBody;
    }

    /**
     * Преобразует DOM-ноды табличных строк в AuctionDTO класс
     *
     * @param DOMElement $rowNode
     * @return AuctionDTO
     */
    private function parseRowNode(DOMElement $rowNode): AuctionDTO
    {
        $parsedNodeData = [];
        $this->iterateNode($rowNode, $parsedNodeData);

        $organizer = new Organizer([
            'name' => $parsedNodeData[2][1] ?? '',
        ]);

        $auction = new Auction([
            'number'     => $parsedNodeData[2][0] ?? '',
            'status'     => $parsedNodeData[2][2] ?? '',
            'date_start' => Carbon::parse($parsedNodeData[2][3] ?? ''),
            'debtor_name' => $parsedNodeData[3][0] ?? '',
        ]);

        $lots = [];
        $rawLots = $parsedNodeData[3] ?? [];

        $lotsCount = 1;
        if (array_key_exists(4, $parsedNodeData))
        {
            $lotsCount = count($parsedNodeData[4]);
        }

        for ($i = 1; $i <= $lotsCount; $i++)
        {
            $lots[] = new Lot([
                'description' => $rawLots[$i * 2],
            ]);
        }

        return new AuctionDTO($auction, $organizer, $lots);
    }

    /**
     * Преобразует DOM-ноды в массив, разложенный по порядку иерархии вложенности нодов
     *
     * @param DOMElement $node
     * @param array $result
     * @param int $depth
     * @return void
     */
    private function iterateNode(DOMElement $node, array &$result, int $depth = 0): void
    {
        if ($node->childNodes->count() > 0)
        {
            $depth++;

            foreach ($node->childNodes as $childNode)
            {
                if ($childNode instanceof DOMElement)
                {
                    $this->iterateNode($childNode, $result, $depth);
                }
                else
                {
                    $nodeText = trim($childNode->textContent);
                    if (strlen($nodeText) > 0)
                    {
                        $result[$depth][] = $nodeText;
                    }
                }
            }
        }
    }
}
