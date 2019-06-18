<?php


namespace App\Http\Controllers\Api;


use App\Domain\Models\SipUser;
use App\Http\Requests\SipUser\CreateSipUserRequest;
use Illuminate\Http\Response;

class SipUserController extends AbstractApiController
{
    /**
     * @param CreateSipUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSipUserRequest $request)
    {
        $existedSipUser = SipUser::query()
                                 ->where('phone_number', $request->getNumber())
                                 ->where('company_id', $request->getCompanyId())
                                 ->first();

        if ($existedSipUser !== null) {
            return $this->respondWithError('Already exist', Response::HTTP_CONFLICT);
        }

        $sipUser = new SipUser();
        $sipUser->accountcode = $request->getCallScope();
        $sipUser->phone_number = $request->getNumber();
        $sipUser->username = $request->getNumber() . $request->getCallScope();
        $sipUser->name = $request->getNumber() . $request->getCallScope();
        $sipUser->secret = strtolower(str_random(6));
        $sipUser->phone_number_id = $request->getPhoneNumberId();
        $sipUser->company_id = $request->getCompanyId();
        $sipUser->save();

        return $this->respondOk($sipUser->toArray());
    }

    /**
     * @param string $apiVersion
     * @param string $phoneNumberId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(string $apiVersion, string $phoneNumberId)
    {
        $sipUser = SipUser::query()
                          ->where('phone_number_id', $phoneNumberId)
                          ->first();

        if($sipUser === null) {
            return $this->respondNotFound();
        }

        $sipUser->delete();

        return $this->respondOk([], 'Successfully deleted');
    }

    /**
     * @param string $apiVersion
     * @param string $phoneNumberId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $apiVersion, string $phoneNumberId)
    {
        $sipUser = SipUser::query()
                          ->where('phone_number_id', $phoneNumberId)
                          ->first();

        if ($sipUser === null) {
            return $this->respondNotFound();
        }

        return $this->respondOk($sipUser->toArray());
    }
}