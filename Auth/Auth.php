<?php

namespace Auth;

class Auth implements \Nerd\Design\Initializable
{
    private static $session;
    private static $model;
    private static $cache = [];

    public static function __initialize()
    {
        static::$session = \Nerd\Session::instance();
        static::$model   = '\\Application\\Model\\User';
    }

    public static function exists($identifier, $ignoreCache = false)
    {
        if (!$ignoreCache) {
            if (array_key_exists($identifier, static::$cache)) {
                return static::$cache[$identifier];
            }
        }

        $model = static::$model;
        $user  = $model::findOneById((int) $identifier);

        static::cache($user);

        return (bool) $user;
    }

    public static function login($identifier, $secret)
    {
        static::logout();

        if (empty($identifier) or empty($secret)) {
            return false;
        }

        if ($user = static::validate($identifier, $secret)) {
            // Update last login value
            $user->ip = \Nerd\Input::ip();
            $user->update();

            static::$session->set('admin.user', (int) $user->id);
            static::$session->set('admin.provider', 'Auth');

            return true;
        }

        return false;
    }

    public static function logout()
    {
        static::$session->delete('admin');
        // Destroy cookie
    }

    public static function validate($identifier, $secret)
    {
        // Need to make this actually work.
        $model = static::$model;
        $user = $model::validate($identifier, $secret);

        static::cache($user);

        return $user;
    }

    public static function force(Model\User $user)
    {
        if (!static::exists($user->id)) {
            return false;
        }

        static::cache($user);

        return true;
    }

    /**
     * @return void
     */
    private static function cache($user)
    {
        if ($user and $user instanceof \Model\User) {
            static::$cache[$user->id] = $user;
        }
    }
}
