import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

/*
|--------------------------------------------------------------------------
| Navigation
|--------------------------------------------------------------------------
*/

import "./custom_frontend/navigation/welcome_navigation";
import "./custom_frontend/navigation/navbar-toggle";
import "./custom_frontend/navigation/scroll_progress";

/*
|--------------------------------------------------------------------------
| Maps
|--------------------------------------------------------------------------
*/

import "./custom_frontend/maps/custom_top_map";

/*
|--------------------------------------------------------------------------
| Modals
|--------------------------------------------------------------------------
*/

import "./custom_frontend/modals/phone";
import "./custom_frontend/modals/land_phone";
import "./custom_frontend/modals/language";
import "./custom_frontend/modals/magnified_image_modal";
import "./custom_frontend/modals/custom_footer_modal";
import "./custom_frontend/modals/location_footer_config";
import "./custom_frontend/modals/location_footer_actions";

/*
|--------------------------------------------------------------------------
| UI
|--------------------------------------------------------------------------
*/

import "./custom_frontend/ui/custom_banner";
import "./custom_frontend/ui/facility_dropdown";
import "./custom_frontend/ui/custom_back_top_button";

/*
|--------------------------------------------------------------------------
| SPECIALIST PART
|--------------------------------------------------------------------------
*/
import "./custom_frontend/welcome_page/specialist_section/specialist_config";
import "./custom_frontend/welcome_page/specialist_section/specialist_events";
import "./custom_frontend/welcome_page/specialist_section/specialist_slider";

/*
|--------------------------------------------------------------------------
| LOGIN PART
|--------------------------------------------------------------------------
*/
import "./custom_frontend/login_page/login";
import "./custom_frontend/login_page/problem";
