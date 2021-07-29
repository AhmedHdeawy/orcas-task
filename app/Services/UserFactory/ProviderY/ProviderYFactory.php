<?php
namespace App\Services\UserFactory\ProviderY;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Services\UserFactory\AbstractProviderFactory;

class ProviderYFactory implements AbstractProviderFactory
{
    private array $request;
    private array $data;
    private string $fileName = 'DataProviderY.json';
    private Collection $result;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * Get Data from File 
     *
     *
     * @return void
     */
    public function loadFile()
    {
        $this->data = json_decode(file_get_contents(app_path() . '/Data/' . $this->fileName), true);
    }

    /**
     * Listing Process
     *
     * @return array
     */
    public function list(): void
    {
        $data = collect($this->data);

        $this->result = $this->applyFilters($data, $this->request);
    }


    /**
     * Apply Filters on Data
     *
     * @return array
     */
    public function applyFilters(Collection $collection, array $request): Collection
    {
        $data = $collection;

        if (isset($request['statusCode']) && !empty($request['statusCode'])) {

            $data = $data->where('status', $this->handleStatusCode($request['statusCode']));
        }

        if (isset($request['currency']) && !empty($request['currency'])) {
            $data = $data->where('currency', $request['currency']);
        }

        if (isset($request['balanceMin']) && !empty($request['balanceMin'])) {
            $data = $data->where('balance', '>=', $request['balanceMin']);
        }

        if (isset($request['balanceMax']) && !empty($request['balanceMax'])) {
            $data = $data->where('balance', '<=', $request['balanceMax']);
        }

        return $data;
    }

    /**
     * @param string $status
     * 
     * @return int
     */
    public function handleStatusCode(string $status)
    {
        if ($status == 'authorised') {
            return 100;
        } elseif ($status == 'decline') {
            return 200;
        } else {
            return 300;
        }
    }

    /**
     * Get Response after Format
     *
     * @return mixed $jsonData
     */
    public function formateResult()
    {
        $result = collect();
        // loop through result and reformat it
        $this->result->map(function ($item) use ($result) {
            $itemData = [
                "amount" => $item['balance'],
                "currency" => $item['currency'],
                "email" => $item['email'],
                "status_code" => $item['status'],
                "date" => Carbon::createFromFormat('d/m/Y', $item['created_at'])->format('Y-m-d'),
                "id" => $item['id'],
            ];
            $result->push($itemData);
        });

        return $result;
    }
}
