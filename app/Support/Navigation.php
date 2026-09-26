<?php

namespace App\Support;

/**
 * The main menu, shared by the desktop header, mobile menu and footer.
 */
class Navigation
{
    /**
     * @return array<int, array{label: string, route?: string, params?: array, children?: array, active: array<int, string>}>
     */
    public static function main(): array
    {
        return [
            ['label' => __('Home'), 'route' => 'home', 'active' => ['home']],
            ['label' => __('About'), 'active' => ['about', 'message'], 'children' => [
                ['label' => __('About Us'), 'route' => 'about', 'icon' => 'building'],
                ['label' => __('Chairman\'s Message'), 'route' => 'message', 'params' => ['person' => 'chairman'], 'icon' => 'quote'],
                ['label' => __('Principal\'s Message'), 'route' => 'message', 'params' => ['person' => 'principal'], 'icon' => 'quote'],
            ]],
            ['label' => __('Academic'), 'active' => ['academic', 'school-hours', 'uniform', 'calendar', 'facilities'], 'children' => [
                ['label' => __('Academic Programme'), 'route' => 'academic', 'icon' => 'graduation-cap'],
                ['label' => __('School Hours'), 'route' => 'school-hours', 'icon' => 'clock'],
                ['label' => __('Academic Calendar'), 'route' => 'calendar', 'icon' => 'calendar'],
                ['label' => __('Uniform'), 'route' => 'uniform', 'icon' => 'shirt'],
                ['label' => __('Facilities'), 'route' => 'facilities', 'icon' => 'monitor'],
            ]],
            ['label' => __('Administration'), 'active' => ['administration', 'rules', 'careers'], 'children' => [
                ['label' => __('Administration'), 'route' => 'administration', 'icon' => 'users'],
                ['label' => __('Rules & Regulations'), 'route' => 'rules', 'icon' => 'scroll'],
                ['label' => __('Careers'), 'route' => 'careers', 'icon' => 'briefcase'],
            ]],
            ['label' => __('Admission'), 'active' => ['admission', 'admission.apply'], 'children' => [
                ['label' => __('Admission Information'), 'route' => 'admission', 'icon' => 'file-text'],
                ['label' => __('Apply Online'), 'route' => 'admission.apply', 'icon' => 'send'],
            ]],
            ['label' => __('Notices'), 'route' => 'notices', 'active' => ['notices', 'notices.show']],
            ['label' => __('Gallery'), 'route' => 'gallery', 'active' => ['gallery']],
            ['label' => __('Contact'), 'route' => 'contact', 'active' => ['contact']],
        ];
    }

    public static function url(array $item): string
    {
        return route($item['route'], $item['params'] ?? []);
    }

    public static function isActive(array $item): bool
    {
        return request()->routeIs(...$item['active']);
    }
}
