/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)

// Core UI CSS
require("@coreui/coreui/dist/css/coreui.min.css");
// Custom CSS
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

// Core UI Javascript
require('popper.js/dist/umd/popper.min.js');
require('bootstrap/dist/js/bootstrap.min.js');
require('@coreui/coreui/dist/js/coreui.min.js');
