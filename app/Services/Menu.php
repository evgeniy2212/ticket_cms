<?php

    namespace App\Services;

    use App;
    use Illuminate\Http\Request;

    class Menu
    {
        private $menu_items = '';

        /**
         * @param       $alias
         * @param array $attributes
         *
         * @return mixed
         */
        public function getMenu($alias = 'sidebar_menu', $attributes = [])
        {
            $currentUrl = (request()->path() != '/') ? '/' . request()->path() : '/';

            foreach (config('sidebar.menu') as $key => $menu) {
                $GLOBALS['parent_active'] = '';

                $hasSub   = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
                $hasCaret = (!empty($menu['caret'])) ? '<b class="caret"></b>' : '';
                $hasIcon  = (!empty($menu['icon'])) ? '<i class="' . $menu['icon'] . '"></i>' : '';
                $hasImg   = (!empty($menu['img'])) ? '<div class="icon-img"><img src="' . $menu['img'] . '" /></div>' : '';
                $hasLabel = (!empty($menu['label'])) ? '<span class="label label-theme m-l-5">' . $menu['label'] . '</span>' : '';
                $hasTitle = (!empty($menu['title'])) ? '<span>' . __('backend.'.$menu['title']) . $hasLabel . '</span>' : '';
                $hasBadge = (!empty($menu['badge'])) ? '<span class="badge pull-right">' . $menu['badge'] . '</span>' : '';

                $subMenu = '';

                if (!empty($menu['sub_menu'])) {
                    $GLOBALS['sub_level'] = 0;
                    $subMenu              .= '<ul class="sub-menu">';
                    if ($alias == 'top_menu') {
                        $subMenu .= self::renderHeaderSubMenu($menu['sub_menu'], $currentUrl);
                    } else {
                        $subMenu .= self::renderSubMenu($menu['sub_menu'], $currentUrl);
                    }
                    $subMenu .= '</ul>';
                }
                $active = ($currentUrl == $menu['url']) ? 'active' : '';
                $active = (empty($active) && !empty($GLOBALS['parent_active'])) ? 'active' : $active;
                if ($menu['url'] == '') {
                    $path = 'javascript:;';
                } else {
                    $path = '/' . config('app.backend') . $menu['url'];
                }
                $this->menu_items .= '<li class="' . $hasSub . ' ' . $active . '">
						<a href="' . $path . '">
							' . $hasImg . '
							' . $hasIcon . '
							' . $hasTitle . '
							' . $hasBadge . '
							' . $hasCaret . '
						</a>
						' . $subMenu . '
					</li>
				';
            }
            return $this->menu_items;
        }

        /**
         * @param $value
         * @param $currentUrl
         *
         * @return string
         */
        private function renderHeaderSubMenu($value, $currentUrl)
        {
            $subMenu                                  = '';
            $GLOBALS['sub_level']                     += 1;
            $GLOBALS['active'][$GLOBALS['sub_level']] = '';
            $currentLevel                             = $GLOBALS['sub_level'];
            foreach ($value as $key => $menu) {
                $GLOBALS['subparent_level'] = '';

                $subSubMenu   = '';
                $hasSub       = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
                $hasCaret     = (!empty($menu['sub_menu'])) ? '<b class="caret pull-right"></b>' : '';
                $hasTitle     = (!empty($menu['title'])) ? __('backend.'.$menu['title']) : '';
                $hasHighlight = (!empty($menu['highlight'])) ? '<i class="fa fa-paper-plane text-theme m-l-5"></i>' : '';

                if (!empty($menu['sub_menu'])) {
                    $subSubMenu .= '<ul class="sub-menu">';
                    $subSubMenu .= self::renderHeaderSubMenu($menu['sub_menu'], $currentUrl);
                    $subSubMenu .= '</ul>';
                }

                $active = ($currentUrl == $menu['url']) ? 'active' : '';

                if ($active) {
                    $GLOBALS['parent_active']                     = true;
                    $GLOBALS['active'][$GLOBALS['sub_level'] - 1] = true;
                }
                if (!empty($GLOBALS['active'][$currentLevel])) {
                    $active = 'active';
                }
                if ($menu['url'] == '') {
                    $path = 'javascript:;';
                } else {
                    $path = '/' . config('app.backend') . $menu['url'];
                }

                $subMenu .= '
						<li class="' . $hasSub . ' ' . $active . '">
							<a href="' . $path . '">' . $hasTitle . $hasHighlight . $hasCaret . '</a>
							' . $subSubMenu . '
						</li>
					';
            }
            return $subMenu;
        }

        /**
         * @param $value
         * @param $currentUrl
         *
         * @return string
         */
        private function renderSubMenu($value, $currentUrl)
        {
            $subMenu                                  = '';
            $GLOBALS['sub_level']                     += 1;
            $GLOBALS['active'][$GLOBALS['sub_level']] = '';
            $currentLevel                             = $GLOBALS['sub_level'];
            foreach ($value as $key => $menu) {
                $GLOBALS['subparent_level'] = '';

                $subSubMenu   = '';
                $hasSub       = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
                $hasCaret     = (!empty($menu['sub_menu'])) ? '<b class="caret pull-right"></b>' : '';
                $hasTitle     = (!empty($menu['title'])) ? __('backend.'.$menu['title']) : '';
                $hasHighlight = (!empty($menu['highlight'])) ? '<i class="fa fa-paper-plane text-theme m-l-5"></i>' : '';

                if (!empty($menu['sub_menu'])) {
                    $subSubMenu .= '<ul class="sub-menu">';
                    $subSubMenu .= self::renderSubMenu($menu['sub_menu'], $currentUrl);
                    $subSubMenu .= '</ul>';
                }

                $active = ($currentUrl == $menu['url']) ? 'active' : '';

                if ($active) {
                    $GLOBALS['parent_active']                     = true;
                    $GLOBALS['active'][$GLOBALS['sub_level'] - 1] = true;
                }
                if (!empty($GLOBALS['active'][$currentLevel])) {
                    $active = 'active';
                }
                if ($menu['url'] == '') {
                    $path = 'javascript:;';
                } else {
                    $path = '/' . config('app.backend') . $menu['url'];
                }

                $subMenu .= '
							<li class="' . $hasSub . ' ' . $active . '">
								<a href="' . $path . '">' . $hasCaret . $hasTitle . $hasHighlight . '</a>
								' . $subSubMenu . '
							</li>
						';
            }
            return $subMenu;
        }

    }
