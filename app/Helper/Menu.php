<?php

namespace App\Helper;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class Menu
{
    public static function getmenu($events, $role)
    {
        if($role == "it"){
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

                $event->menu->addAfter('dashboard',
                [
                    'key'  => 'inputwfawfo',
                    'text' => 'Input WFH-WFO',
                    'route'  => 'inputwfawfo.index',
                    'icon' => 'fas fa-fw fa-keyboard',
                ],
                [
                    'key'  => 'reportwfawfo',
                    'text' => 'Report WFH-WFO',
                    'icon' => 'fas fa-fw fa-file-alt',
                    'submenu' => [
                        [
                            'text' => 'All',
                            'route'  => 'report',
                        ],
                        [
                            'text' => 'Schedule',
                            'route'  => 'schedule',
                        ],
                        [
                            'text' => 'Food',
                            'route'  => 'food',
                        ],
                    ]
                ],
                [
                    'key'  => 'master',
                    'text' => 'Master',
                    'icon' => 'fas fa-fw fa-server',
                    'submenu' => [
                        [
                            'text' => 'Jadwal Kerja',
                            'route'  => 'masterkerja.index',
                            'icon' => 'fas fa-fw fa-briefcase'
                        ],
                        [
                            'text' => 'Makan Siang',
                            'route'  => 'mastermakanan.index',
                            'icon' => 'fas fa-fw fa-utensils'
                        ],
                        [
                            'text' => 'User',
                            'route'  => 'masteruser.index',
                            'icon' => 'fas fa-fw fa-user-plus'
                        ],
                        [
                            'text' => 'Periode',
                            'route'  => 'masterperiode.index',
                            'icon' => 'fas fa-fw fa-clock'
                        ],
                        [
                            'text' => 'Hari Libur',
                            'route'  => 'masterharilibur.index',
                            'icon' => 'fas fa-fw fa-calendar-week'
                        ],
                        [
                            'text' => 'Department',
                            'route'  => 'masterdepartment',
                            'icon' => 'fas fa-fw fa-building'
                        ]
                    ]
                ]
                );
            });
        }elseif ($role == "pichrd") {
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

                $event->menu->addAfter('dashboard',
                [
                    'key'  => 'inputwfawfo',
                    'text' => 'Input WFH-WFO',
                    'route'  => 'inputwfawfo.index',
                    'icon' => 'fas fa-fw fa-keyboard',
                ],
                [
                    'key'  => 'reportwfawfo',
                    'text' => 'Report WFH-WFO',
                    'route'  => 'report',
                    'icon' => 'fas fa-fw fa-file-alt',
                ],
                [
                    'key'  => 'master',
                    'text' => 'Master',
                    'icon' => 'fas fa-fw fa-server',
                    'submenu' => [
                        [
                            'text' => 'Jadwal Kerja',
                            'route'  => 'masterkerja.index',
                            'icon' => 'fas fa-fw fa-briefcase'
                        ],
                        [
                            'text' => 'Makan Siang',
                            'route'  => 'mastermakanan.index',
                            'icon' => 'fas fa-fw fa-utensils'
                        ],
                        [
                            'text' => 'User',
                            'route'  => 'masteruser.index',
                            'icon' => 'fas fa-fw fa-user-plus'
                        ],
                        [
                            'text' => 'Periode',
                            'route'  => 'masterperiode.index',
                            'icon' => 'fas fa-fw fa-user-clock'
                        ],
                        [
                            'text' => 'Hari Libur',
                            'route'  => 'masterharilibur.index',
                            'icon' => 'fas fa-fw fa-calendar-week'
                        ],
                        [
                            'text' => 'Department',
                            'route'  => 'masterdepartment',
                            'icon' => 'fas fa-fw fa-building'
                        ]
                    ]
                ]
                );
            });
        }elseif ($role == "depthead") {
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

                $event->menu->addAfter('dashboard',
                [
                    'key'  => 'inputwfawfo',
                    'text' => 'Input WFH-WFO',
                    'route'  => 'inputwfawfo.index',
                    'icon' => 'fas fa-fw fa-keyboard',
                ],
                [
                    'key'  => 'approvewfawfo',
                    'text' => 'Approve WFH-WFO',
                    'route'  => 'approvewfawfo.index',
                    'icon' => 'fas fa-fw fa-thumbs-up',
                ]
                );
            });
        }elseif ($role == "direktur") {
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

                $event->menu->addAfter('dashboard',
                [
                    'key'  => 'approvewfawfo',
                    'text' => 'Approve WFH-WFO',
                    'route'  => 'approvewfawfo.index',
                    'icon' => 'fas fa-fw fa-thumbs-up',
                ]
                );
            });
        }else{
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

                $event->menu->addAfter('dashboard',
                [
                    'key'  => 'inputwfawfo',
                    'text' => 'Input WFH-WFO',
                    'route'  => 'inputwfawfo.index',
                    'icon' => 'fas fa-fw fa-keyboard',
                ]
                );
            });
        }
    }
}
