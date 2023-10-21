<?php

namespace App\Services;

use APIResponse;
use App\Models\ActivityLogger;
use Auth;
use Exception;
use Request;

/**
 * Class ActivityTrackerService.
 */
class ActivityTrackerService
{
/**
     * Log Activity.
     *
     * @param null $description
     * @param null $details
     *
     * @return void
     */
    public function track($description = null, $details = null)
    {
        try {
            $user_type = "GUEST";
            $user_id = null;

            if (Auth::check()) {
                $user_type = "REGISTERED";
                $user_id = Request::user()->id;
            }


            if (!$description) {
                switch (strtolower(Request::method())) {
                    case 'post':
                        $verb = 'CREATE';
                        break;

                    case 'patch':
                    case 'put':
                        $verb = 'EDIT';
                        break;

                    case 'delete':
                        $verb = 'DELETE';
                        break;

                    case 'get':
                    default:
                        $verb = 'GET';
                        break;
                }

                $description = $verb . ' - ' . Request::path();
            }

            if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
                $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = Request::ip();
            }

            $data = [
                'description'   => $description,
                'details'       => $details ? json_encode($details , true) : null,
                'userType'      => $user_type,
                'userId'        => $user_id,
                'route'         => Request::fullUrl(),
                'ipAddress'     => $ip,
                'userAgent'     => Request::header('user-agent'),
                'referer'       => Request::header('referer'),
                'methodType'    => Request::method(),
            ];

            self::storeActivity($data);
            $response_data = APIResponse::createdResponse($data);
            infoLog(__METHOD__, "Activity tracker log inserted ", json_encode($response_data));
        } catch (Exception $e) {
            $response_data = APIResponse::errorResponse([], $e->getMessage());
            errorLog(__METHOD__, "Activity tracker error", json_encode($response_data));
        }
    }

    /**
     * Store activity entry to database.
     *
     * @param array $data
     *
     * @return void
     */
    private static function storeActivity($data)
    {
        ActivityLogger::create([
            'description'   => $data['description'],
            'details'       => $data['details'],
            'userType'      => $data['userType'],
            'userId'        => $data['userId'],
            'route'         => $data['route'],
            'ipAddress'     => $data['ipAddress'],
            'userAgent'     => $data['userAgent'],
            'referer'       => $data['referer'],
            'methodType'    => $data['methodType'],
        ]);
    }
}
