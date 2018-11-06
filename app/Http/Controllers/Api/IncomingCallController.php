<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\SetUpCallRequest;
use Illuminate\Http\Response;
use InternalApi\PbxSchemeServiceApi\PbxSchemeServiceApi;
use InternalApi\PhoneNumberServiceApi\PhoneNumberServiceApi;

class IncomingCallController extends Controller
{
    /**
     * @param string           $apiVersion
     * @param SetUpCallRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function callSetUp(string $apiVersion, SetUpCallRequest $request)
    {
        /** @var PhoneNumberServiceApi $phoneNumberServiceApi */
        $phoneNumberServiceApi = app('phone_number_service_api');

        $did = $phoneNumberServiceApi->didPhoneNumber()->getByPhoneNumber($request->getDidNumber());

        if ($did === null) {
            return response()->json(
                [
                    'code'    => Response::HTTP_BAD_REQUEST,
                    'message' => 'did number not found',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($did->getStatus() !== 'active') {
            return response()->json(
                [
                    'code'    => Response::HTTP_BAD_REQUEST,
                    'message' => 'did number is not active',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($did->getPbxId() === null) {
            return response()->json(
                [
                    'code'    => Response::HTTP_BAD_REQUEST,
                    'message' => 'did number is not attached to any pbx',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        /** @var PbxSchemeServiceApi $pbxSchemeServiceApi */
        $pbxSchemeServiceApi = app('pbx_scheme_service_api');
        $pbx                 = $pbxSchemeServiceApi->pbx()->get($did->getPbxId());

        if ($pbx === null) {
            return response()->json(
                [
                    'code'    => Response::HTTP_BAD_REQUEST,
                    'message' => 'Pbx not found',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json($pbx);
    }
}
