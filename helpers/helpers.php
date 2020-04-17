<?php
    use Capmega\Base\Models\Cdn;

    function asset($path, $secure = null, $image = false)
    {
        $cnd = Cdn::where('status', Cdn::STATUS_ACTIVE)->where('type', strtoupper(\App::environment()))->first();

        if ($image) {
            if (strpos(\Request::server('HTTP_ACCEPT'), 'webp') !== false) {
                $path = \str_replace(['.jpg', '.jpeg', '.png'], '.webp', $path);
            }
        }

        if ($cnd) {
            return app('url')->assetFrom(request_is_https().$cnd->domain, $path, $secure);
        }

        return app('url')->asset($path, $secure);
    }

    function request_is_https(){
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            return 'https://';
        }
        return 'http://';
    }

    function to_route($url, $param = false){
        if ($param) {
            return route($url, $param);
        }

        if (is_array($url)) {
            return route($url[0], $url[1]);
        }

        if (substr( $url, 0, 4 ) === "http" || substr( $url, 0, 1 ) === "&") {
            return $url;
        }

        if (substr( $url, 0, 1 ) === "#") {
            return $url;
        }

        return route($url);

    }
?>
