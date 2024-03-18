<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Spatie\Color\Hex;
use Spatie\Color\Rgb;

class Colors
{
    public const Slate = [
        100 => '248, 250, 252',
        200 => '241, 245, 249',
        300 => '226, 232, 240',
        400 => '203, 213, 225',
        500 => '148, 163, 184',
        600 => '100, 116, 139',
        700 => '71, 85, 105',
        800 => '51, 65, 85',
        900 => '30, 41, 59',
    ];

    public const Gray = [
        100 => '249, 250, 251',
        200 => '243, 244, 246',
        300 => '229, 231, 235',
        400 => '209, 213, 219',
        500 => '156, 163, 175',
        600 => '107, 114, 128',
        700 => '75, 85, 99',
        800 => '55, 65, 81',
        900 => '31, 41, 55',
    ];

    public const Zinc = [
        100 => '250, 250, 250',
        200 => '244, 244, 245',
        300 => '228, 228, 231',
        400 => '212, 212, 216',
        500 => '161, 161, 170',
        600 => '113, 113, 122',
        700 => '82, 82, 91',
        800 => '63, 63, 70',
        900 => '39, 39, 42',
    ];

    public const Neutral = [
        100 => '250, 250, 250',
        200 => '245, 245, 245',
        300 => '229, 229, 229',
        400 => '212, 212, 212',
        500 => '163, 163, 163',
        600 => '115, 115, 115',
        700 => '82, 82, 82',
        800 => '64, 64, 64',
        900 => '38, 38, 38',
    ];

    public const Stone = [
        100 => '250, 250, 249',
        200 => '245, 245, 244',
        300 => '231, 229, 228',
        400 => '214, 211, 209',
        500 => '168, 162, 158',
        600 => '120, 113, 108',
        700 => '87, 83, 78',
        800 => '68, 64, 60',
        900 => '41, 37, 36',
    ];

    public const Red = [
        100 => '254, 242, 242',
        200 => '254, 226, 226',
        300 => '254, 202, 202',
        400 => '252, 165, 165',
        500 => '248, 113, 113',
        600 => '239, 68, 68',
        700 => '220, 38, 38',
        800 => '185, 28, 28',
        900 => '153, 27, 27',
    ];

    public const Orange = [
        100 => '255, 247, 237',
        200 => '255, 237, 213',
        300 => '254, 215, 170',
        400 => '253, 186, 116',
        500 => '251, 146, 60',
        600 => '249, 115, 22',
        700 => '234, 88, 12',
        800 => '194, 65, 12',
        900 => '154, 52, 18',
    ];

    public const Amber = [
        100 => '255, 251, 235',
        200 => '254, 243, 199',
        300 => '253, 230, 138',
        400 => '252, 211, 77',
        500 => '251, 191, 36',
        600 => '245, 158, 11',
        700 => '217, 119, 6',
        800 => '180, 83, 9',
        900 => '146, 64, 14',
    ];

    public const Yellow = [
        100 => '254, 252, 232',
        200 => '254, 249, 195',
        300 => '254, 240, 138',
        400 => '253, 224, 71',
        500 => '250, 204, 21',
        600 => '234, 179, 8',
        700 => '202, 138, 4',
        800 => '161, 98, 7',
        900 => '133, 77, 14',
    ];

    public const Lime = [
        100 => '247, 254, 231',
        200 => '236, 252, 203',
        300 => '217, 249, 157',
        400 => '190, 242, 100',
        500 => '163, 230, 53',
        600 => '132, 204, 22',
        700 => '101, 163, 13',
        800 => '77, 124, 15',
        900 => '63, 98, 18',
    ];

    public const Green = [
        100 => '240, 253, 244',
        200 => '220, 252, 231',
        300 => '187, 247, 208',
        400 => '134, 239, 172',
        500 => '74, 222, 128',
        600 => '34, 197, 94',
        700 => '22, 163, 74',
        800 => '21, 128, 61',
        900 => '22, 101, 52',
    ];

    public const Emerald = [
        100 => '236, 253, 245',
        200 => '209, 250, 229',
        300 => '167, 243, 208',
        400 => '110, 231, 183',
        500 => '52, 211, 153',
        600 => '16, 185, 129',
        700 => '5, 150, 105',
        800 => '4, 120, 87',
        900 => '6, 95, 70',
    ];

    public const Teal = [
        100 => '240, 253, 250',
        200 => '204, 251, 241',
        300 => '153, 246, 228',
        400 => '94, 234, 212',
        500 => '45, 212, 191',
        600 => '20, 184, 166',
        700 => '13, 148, 136',
        800 => '15, 118, 110',
        900 => '17, 94, 89',
    ];

    public const Cyan = [
        100 => '236, 254, 255',
        200 => '207, 250, 254',
        300 => '165, 243, 252',
        400 => '103, 232, 249',
        500 => '34, 211, 238',
        600 => '6, 182, 212',
        700 => '8, 145, 178',
        800 => '14, 116, 144',
        900 => '21, 94, 117',
    ];

    public const Sky = [
        100 => '240, 249, 255',
        200 => '224, 242, 254',
        300 => '186, 230, 253',
        400 => '125, 211, 252',
        500 => '56, 189, 248',
        600 => '14, 165, 233',
        700 => '2, 132, 199',
        800 => '3, 105, 161',
        900 => '7, 89, 133',
    ];

    public const Blue = [
        100 => '239, 246, 255',
        200 => '219, 234, 254',
        300 => '191, 219, 254',
        400 => '147, 197, 253',
        500 => '96, 165, 250',
        600 => '59, 130, 246',
        700 => '37, 99, 235',
        800 => '29, 78, 216',
        900 => '30, 64, 175',
    ];

    public const Indigo = [
        100 => '238, 242, 255',
        200 => '224, 231, 255',
        300 => '199, 210, 254',
        400 => '165, 180, 252',
        500 => '129, 140, 248',
        600 => '99, 102, 241',
        700 => '79, 70, 229',
        800 => '67, 56, 202',
        900 => '55, 48, 163',
    ];

    public const Violet = [
        100 => '245, 243, 255',
        200 => '237, 233, 254',
        300 => '221, 214, 254',
        400 => '196, 181, 253',
        500 => '167, 139, 250',
        600 => '139, 92, 246',
        700 => '124, 58, 237',
        800 => '109, 40, 217',
        900 => '91, 33, 182',
    ];

    public const Purple = [
        100 => '250, 245, 255',
        200 => '243, 232, 255',
        300 => '233, 213, 255',
        400 => '216, 180, 254',
        500 => '192, 132, 252',
        600 => '168, 85, 247',
        700 => '147, 51, 234',
        800 => '126, 34, 206',
        900 => '107, 33, 168',
    ];

    public const Fuchsia = [
        100 => '253, 244, 255',
        200 => '250, 232, 255',
        300 => '245, 208, 254',
        400 => '240, 171, 252',
        500 => '232, 121, 249',
        600 => '217, 70, 239',
        700 => '192, 38, 211',
        800 => '162, 28, 175',
        900 => '134, 25, 143',
    ];

    public const Pink = [
        100 => '253, 242, 248',
        200 => '252, 231, 243',
        300 => '251, 207, 232',
        400 => '249, 168, 212',
        500 => '244, 114, 182',
        600 => '236, 72, 153',
        700 => '219, 39, 119',
        800 => '190, 24, 93',
        900 => '157, 23, 77',
    ];

    public const Rose = [
        100 => '255, 241, 242',
        200 => '255, 228, 230',
        300 => '254, 205, 211',
        400 => '253, 164, 175',
        500 => '251, 113, 133',
        600 => '244, 63, 94',
        700 => '225, 29, 72',
        800 => '190, 18, 60',
        900 => '159, 18, 57',
    ];

    /**
     * @return array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string}
     */
    public static function hex(string $color): array
    {
        return static::generateShades(Hex::fromString($color)->toRgb());
    }

    /**
     * @return array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string}
     */
    public static function rgb(string $color): array
    {
        return static::generateShades(Rgb::fromString($color));
    }

    /**
     * @return array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string}
     */
    protected static function generateShades(Rgb $color): array
    {
        $colors = [];

        $intensityMap = [
            100 => 0.85,
            200 => 0.8,
            300 => 0.65,
            400 => 0.5,
            500 => 0.2,
            700 => 0.8,
            800 => 0.65,
            900 => 0.5,
        ];

        foreach ([100, 200, 300, 400, 500] as $shade) {
            $intensity = $intensityMap[$shade];

            $red = round(intval($color->red()) + (255 - intval($color->red())) * $intensity);
            $green = round(intval($color->green()) + (255 - intval($color->green())) * $intensity);
            $blue = round(intval($color->blue()) + (255 - intval($color->blue())) * $intensity);

            $colors[$shade] = "{$red}, {$green}, {$blue}";
        }

        $colors[600] = "{$color->red()}, {$color->green()}, {$color->blue()}";

        foreach ([700, 800, 900] as $shade) {
            $intensity = $intensityMap[$shade];

            $red = round(intval($color->red()) * $intensity);
            $green = round(intval($color->green()) * $intensity);
            $blue = round(intval($color->blue()) * $intensity);

            $colors[$shade] = "{$red}, {$green}, {$blue}";
        }

        return $colors;
    }
}