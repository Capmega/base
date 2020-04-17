<?php
namespace Capmega\Base\Widgets\Information;

/**
 *
 */
class BreadCrumb
{
    public static function generate($params, $title = false)
    {
        $bread_crum  = '<div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">';
        if ($title) {
            $bread_crum .= '<h3 class="content-header-title mb-0 d-inline-block">'.$title.'</h3>';
        }
        $bread_crum .= '
                        <div class="row breadcrumbs-top d-inline-block">
                          <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item">
                                <a href="'.route('dashboard').'">'.__('base::messages.dashboard').'</a>
                              </li>';
        foreach ($params as $key => $value) {
            if ($key != 'Active') {
                $bread_crum .= '<li class="breadcrumb-item">
                                    <a href="'.route($key).'">'.$value.'</a>
                                </li>';
            }
        }
        $bread_crum .= '    <li class="breadcrumb-item active">'.$params['Active'].'</li>';
        $bread_crum .= '</ol></div></div></div>';

        return $bread_crum;
    }
}
