<?php
/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/24
 * Time: 20:02
 */

namespace HuanLe\DBQuery\Result;


class QueryResponse
{
    /**
     * @var
     */
    private $requestParam;

    /**
     * @var
     */
    private $responseData;

    /**
     * QueryResponse constructor.
     *
     * @param $requestParam
     * @param $responseData
     */
    public function __construct($requestParam, $responseData)
    {
        $this->requestParam = $requestParam;
        $this->responseData = $responseData;
    }

    /**
     * @explain assemble data of response
     * @return array
     * @author timorchao
     */
    public function response(): array
    {
        //If different types of return values are required, they can be handled separately according to requestParam
        //instance default (BJ_KUDU,BJ_MySql,Office_MySql)
        $datas = ['results' => []];

        //get RequestId
        if (isset($this->responseData['RequestId'])) {
            $datas['RequestId'] = $this->responseData['RequestId'];
        }

        //get AsyncRequestId
        if (isset($this->responseData['AsyncRequestId'])) {
            $datas['AsyncRequestId'] = $this->responseData['AsyncRequestId'];
        }

        if (isset($this->responseData['data']['msg'])) {
            $datas['msg'] = $this->responseData['data']['msg'];
        }

        if (isset($this->responseData['data']['code'])) {
            $datas['code'] = $this->responseData['data']['code'];
        }

        // datas
        if (isset($this->responseData['data']['values']) && !empty($this->responseData['data']['values'])) {
            foreach ($this->responseData['data']['values'] as $data) {
                $tmp = [];
                foreach ($data as $key => $value) {
                    if (isset($this->responseData['data']['columns'][$key])) {
                        $tmp[$this->responseData['data']['columns'][$key]] = $value;
                    }
                }
                $datas['results'][] = $tmp;
            }
        }

        // handle pagination
        if (!empty($this->requestParam['page']) && !$this->requestParam['async']) {
            $datas['total']      = isset($this->responseData['RowCount']) && $this->responseData['RowCount'] > 0 ?
                $this->responseData['RowCount'] : 0;
            $datas['pagination'] = [
                'total'        => 0,
                'per_page'     => (int)$this->requestParam['PageSize'],
                'current_page' => (int)$this->requestParam['CurrentPage']
            ];
            if (!empty($datas['total'])) {
                $datas['pagination']['total'] = (int)$datas['total'];
            }
        }
        return $datas;
    }
}