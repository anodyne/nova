<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Install Genre - DND
 *
 * @package		Nova
 * @category	Genre
 * @author		Wade Duerkes
 */

$g = 'dnd';

$depts = array(
    array(
        'dept_name' => 'Game Administrators',
        'dept_desc' => "Game Administrators are those who organize and run the various adventures. These are non-playing characters. Posts from a Game Administrator should be viewed as out of character unless otherwise instructed.",
        'dept_order' => 0,
        'dept_manifest' => 1),
    array(
        'dept_name' => 'Warriors',
        'dept_desc' => "A class made up of characters who have exceptional combat capability and unequaled skill with weapons.",
        'dept_order' => 1,
        'dept_manifest' => 1),
    array(
        'dept_name' => 'Magic Users',
        'dept_desc' => "A class made up of characters who are schooled in the arcane arts.",
        'dept_order' => 2,
        'dept_manifest' => 1),
    array(
        'dept_name' => 'Priests',
        'dept_desc' => "A class made up of characters who cast divine spells and are also capable in combat.",
        'dept_order' => 3,
        'dept_manifest' => 1),
    array(
        'dept_name' => 'Thieves',
        'dept_desc' => "A class made up of characters who primarily rely on stealth rather than brute force or magical ability.",
        'dept_order' => 4,
        'dept_manifest' => 1),
);

$ranks = array(
    array(
        'rank_name' => 'Dungeon Master',
        'rank_short_name' => 'DM',
        'rank_image' => 'dm',
        'rank_order' => 0,
        'rank_class' => 1),
    array(
        'rank_name' => 'Game Master',
        'rank_short_name' => 'GM',
        'rank_image' => 'gm',
        'rank_order' => 1,
        'rank_class' => 1),
    array(
        'rank_name' => 'Referee',
        'rank_short_name' => 'REF',
        'rank_image' => 'ref',
        'rank_order' => 2,
        'rank_class' => 1),

    array(
        'rank_name' => 'Fighter (Level 20)',
        'rank_short_name' => 'F20',
        'rank_image' => 'fighter-20',
        'rank_order' => 0,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 19)',
        'rank_short_name' => 'F19',
        'rank_image' => 'fighter-19',
        'rank_order' => 1,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 18)',
        'rank_short_name' => 'F18',
        'rank_image' => 'fighter-18',
        'rank_order' => 2,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 17)',
        'rank_short_name' => 'F17',
        'rank_image' => 'fighter-17',
        'rank_order' => 3,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 16)',
        'rank_short_name' => 'F16',
        'rank_image' => 'fighter-16',
        'rank_order' => 4,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 15)',
        'rank_short_name' => 'F15',
        'rank_image' => 'fighter-15',
        'rank_order' => 5,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 14)',
        'rank_short_name' => 'F14',
        'rank_image' => 'fighter-14',
        'rank_order' => 6,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 13)',
        'rank_short_name' => 'F13',
        'rank_image' => 'fighter-13',
        'rank_order' => 7,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 12)',
        'rank_short_name' => 'F12',
        'rank_image' => 'fighter-12',
        'rank_order' => 8,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 11)',
        'rank_short_name' => 'F11',
        'rank_image' => 'fighter-11',
        'rank_order' => 9,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 10)',
        'rank_short_name' => 'F10',
        'rank_image' => 'fighter-10',
        'rank_order' => 10,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 9)',
        'rank_short_name' => 'F9',
        'rank_image' => 'fighter-9',
        'rank_order' => 11,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 8)',
        'rank_short_name' => 'F8',
        'rank_image' => 'fighter-8',
        'rank_order' => 12,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 7)',
        'rank_short_name' => 'F7',
        'rank_image' => 'fighter-7',
        'rank_order' => 13,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 6)',
        'rank_short_name' => 'F6',
        'rank_image' => 'fighter-6',
        'rank_order' => 14,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 5)',
        'rank_short_name' => 'F5',
        'rank_image' => 'fighter-5',
        'rank_order' => 15,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 4)',
        'rank_short_name' => 'F4',
        'rank_image' => 'fighter-4',
        'rank_order' => 16,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 3)',
        'rank_short_name' => 'F3',
        'rank_image' => 'fighter-3',
        'rank_order' => 17,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 2)',
        'rank_short_name' => 'F2',
        'rank_image' => 'fighter-2',
        'rank_order' => 18,
        'rank_class' => 2),
    array(
        'rank_name' => 'Fighter (Level 1)',
        'rank_short_name' => 'F1',
        'rank_image' => 'fighter-1',
        'rank_order' => 19,
        'rank_class' => 2),

    array(
        'rank_name' => 'Wizard (Level 20)',
        'rank_short_name' => 'W20',
        'rank_image' => 'wizard-20',
        'rank_order' => 0,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 19)',
        'rank_short_name' => 'W19',
        'rank_image' => 'wizard-19',
        'rank_order' => 1,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 18)',
        'rank_short_name' => 'W18',
        'rank_image' => 'wizard-18',
        'rank_order' => 2,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 17)',
        'rank_short_name' => 'W17',
        'rank_image' => 'wizard-17',
        'rank_order' => 3,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 16)',
        'rank_short_name' => 'W16',
        'rank_image' => 'wizard-16',
        'rank_order' => 4,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 15)',
        'rank_short_name' => 'W15',
        'rank_image' => 'wizard-15',
        'rank_order' => 5,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 14)',
        'rank_short_name' => 'W14',
        'rank_image' => 'wizard-14',
        'rank_order' => 6,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 13)',
        'rank_short_name' => 'W13',
        'rank_image' => 'wizard-13',
        'rank_order' => 7,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 12)',
        'rank_short_name' => 'W12',
        'rank_image' => 'wizard-12',
        'rank_order' => 8,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 11)',
        'rank_short_name' => 'W11',
        'rank_image' => 'wizard-11',
        'rank_order' => 9,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 10)',
        'rank_short_name' => 'W10',
        'rank_image' => 'wizard-10',
        'rank_order' => 10,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 9)',
        'rank_short_name' => 'W9',
        'rank_image' => 'wizard-9',
        'rank_order' => 11,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 8)',
        'rank_short_name' => 'W8',
        'rank_image' => 'wizard-8',
        'rank_order' => 12,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 7)',
        'rank_short_name' => 'W7',
        'rank_image' => 'wizard-7',
        'rank_order' => 13,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 6)',
        'rank_short_name' => 'W6',
        'rank_image' => 'wizard-6',
        'rank_order' => 14,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 5)',
        'rank_short_name' => 'W5',
        'rank_image' => 'wizard-5',
        'rank_order' => 15,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 4)',
        'rank_short_name' => 'W4',
        'rank_image' => 'wizard-4',
        'rank_order' => 16,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 3)',
        'rank_short_name' => 'W3',
        'rank_image' => 'wizard-3',
        'rank_order' => 17,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 2)',
        'rank_short_name' => 'W2',
        'rank_image' => 'wizard-2',
        'rank_order' => 18,
        'rank_class' => 3),
    array(
        'rank_name' => 'Wizard (Level 1)',
        'rank_short_name' => 'W1',
        'rank_image' => 'wizard-1',
        'rank_order' => 19,
        'rank_class' => 3),

    array(
        'rank_name' => 'Priest (Level 20)',
        'rank_short_name' => 'P20',
        'rank_image' => 'priest-20',
        'rank_order' => 0,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 19)',
        'rank_short_name' => 'P19',
        'rank_image' => 'priest-19',
        'rank_order' => 1,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 18)',
        'rank_short_name' => 'P18',
        'rank_image' => 'priest-18',
        'rank_order' => 2,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 17)',
        'rank_short_name' => 'P17',
        'rank_image' => 'priest-17',
        'rank_order' => 3,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 16)',
        'rank_short_name' => 'P16',
        'rank_image' => 'priest-16',
        'rank_order' => 4,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 15)',
        'rank_short_name' => 'P15',
        'rank_image' => 'priest-15',
        'rank_order' => 5,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 14)',
        'rank_short_name' => 'P14',
        'rank_image' => 'priest-14',
        'rank_order' => 6,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 13)',
        'rank_short_name' => 'P13',
        'rank_image' => 'priest-13',
        'rank_order' => 7,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 12)',
        'rank_short_name' => 'P12',
        'rank_image' => 'priest-12',
        'rank_order' => 8,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 11)',
        'rank_short_name' => 'P11',
        'rank_image' => 'priest-11',
        'rank_order' => 9,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 10)',
        'rank_short_name' => 'P10',
        'rank_image' => 'priest-10',
        'rank_order' => 10,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 9)',
        'rank_short_name' => 'P9',
        'rank_image' => 'priest-9',
        'rank_order' => 11,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 8)',
        'rank_short_name' => 'P8',
        'rank_image' => 'priest-8',
        'rank_order' => 12,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 7)',
        'rank_short_name' => 'P7',
        'rank_image' => 'priest-7',
        'rank_order' => 13,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 6)',
        'rank_short_name' => 'P6',
        'rank_image' => 'priest-6',
        'rank_order' => 14,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 5)',
        'rank_short_name' => 'P5',
        'rank_image' => 'priest-5',
        'rank_order' => 15,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 4)',
        'rank_short_name' => 'P4',
        'rank_image' => 'priest-4',
        'rank_order' => 16,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 3)',
        'rank_short_name' => 'P3',
        'rank_image' => 'priest-3',
        'rank_order' => 17,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 2)',
        'rank_short_name' => 'P2',
        'rank_image' => 'priest-2',
        'rank_order' => 18,
        'rank_class' => 4),
    array(
        'rank_name' => 'Priest (Level 1)',
        'rank_short_name' => 'P1',
        'rank_image' => 'priest-1',
        'rank_order' => 19,
        'rank_class' => 4),

    array(
        'rank_name' => 'Thief (Level 20)',
        'rank_short_name' => 'T20',
        'rank_image' => 'thief-20',
        'rank_order' => 0,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 19)',
        'rank_short_name' => 'T19',
        'rank_image' => 'thief-19',
        'rank_order' => 1,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 18)',
        'rank_short_name' => 'T18',
        'rank_image' => 'thief-18',
        'rank_order' => 2,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 17)',
        'rank_short_name' => 'T17',
        'rank_image' => 'thief-17',
        'rank_order' => 3,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 16)',
        'rank_short_name' => 'T16',
        'rank_image' => 'thief-16',
        'rank_order' => 4,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 15)',
        'rank_short_name' => 'T15',
        'rank_image' => 'thief-15',
        'rank_order' => 5,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 14)',
        'rank_short_name' => 'T14',
        'rank_image' => 'thief-14',
        'rank_order' => 6,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 13)',
        'rank_short_name' => 'T13',
        'rank_image' => 'thief-13',
        'rank_order' => 7,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 12)',
        'rank_short_name' => 'T12',
        'rank_image' => 'thief-12',
        'rank_order' => 8,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 11)',
        'rank_short_name' => 'T11',
        'rank_image' => 'thief-11',
        'rank_order' => 9,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 10)',
        'rank_short_name' => 'T10',
        'rank_image' => 'thief-10',
        'rank_order' => 10,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 9)',
        'rank_short_name' => 'T9',
        'rank_image' => 'thief-9',
        'rank_order' => 11,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 8)',
        'rank_short_name' => 'T8',
        'rank_image' => 'thief-8',
        'rank_order' => 12,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 7)',
        'rank_short_name' => 'T7',
        'rank_image' => 'thief-7',
        'rank_order' => 13,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 6)',
        'rank_short_name' => 'T6',
        'rank_image' => 'thief-6',
        'rank_order' => 14,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 5)',
        'rank_short_name' => 'T5',
        'rank_image' => 'thief-5',
        'rank_order' => 15,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 4)',
        'rank_short_name' => 'T4',
        'rank_image' => 'thief-4',
        'rank_order' => 16,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 3)',
        'rank_short_name' => 'T3',
        'rank_image' => 'thief-3',
        'rank_order' => 17,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 2)',
        'rank_short_name' => 'T2',
        'rank_image' => 'thief-2',
        'rank_order' => 18,
        'rank_class' => 5),
    array(
        'rank_name' => 'Thief (Level 1)',
        'rank_short_name' => 'T1',
        'rank_image' => 'thief-1',
        'rank_order' => 19,
        'rank_class' => 5)
);

$positions = array(
    array(
        'pos_name' => 'Dungeon Master',
        'pos_desc' => "The Dungeon Master is the highest ranking Game Administrators. They have final say in all things happening on this sim.",
        'pos_dept' => 1,
        'pos_order' => 0,
        'pos_open' => 1,
        'pos_type' => 'senior'),
    array(
        'pos_name' => 'Game Master',
        'pos_desc' => "The difference between the Dungeon Master and the Game Master is the Game Master is the person in charge of a specific adventure.",
        'pos_dept' => 1,
        'pos_order' => 1,
        'pos_open' => 1,
        'pos_type' => 'senior'),
    array(
        'pos_name' => 'Referee',
        'pos_desc' => "Referees maybe appointed by Game Masters or the Dungeon Master to oversee smaller portions of an adventure as needed.",
        'pos_dept' => 1,
        'pos_order' => 2,
        'pos_open' => 1,
        'pos_type' => 'senior'),
    array(
        'pos_name' => 'Fighter',
        'pos_desc' => "A class made up of characters who have exceptional combat capability and unequaled skill with weapons.",
        'pos_dept' => 2,
        'pos_order' => 0,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Paladin',
        'pos_desc' => "A class made up of characters who are champions of justice and destroyers of evil, with an array of divine powers.",
        'pos_dept' => 2,
        'pos_order' => 1,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Ranger',
        'pos_desc' => "A class made up of characters who are particularly skilled at adventuring in the wilderness.",
        'pos_dept' => 2,
        'pos_order' => 2,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Barbarian',
        'pos_desc' => "A class made up of ferocious warriors who use inborn fury and instinct to bring down foes.",
        'pos_dept' => 2,
        'pos_order' => 3,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Illusionist',
        'pos_desc' => "A class made up of characters who use Illusion spells to deceive the senses or minds of others.",
        'pos_dept' => 3,
        'pos_order' => 0,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Sorcerer',
        'pos_desc' => "A class made up of characters who have inborn magical ability.",
        'pos_dept' => 3,
        'pos_order' => 1,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Wizard',
        'pos_desc' => "A class made up of characters who are schooled in the arcane arts.",
        'pos_dept' => 3,
        'pos_order' => 2,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Necromancer',
        'pos_desc' => "A class made up of characters who use Necromancy spells to manipulate the power of death, unlife, and the life force. Spells involving undead creatures make up a large part of this school.",
        'pos_dept' => 3,
        'pos_order' => 3,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Abjurer',
        'pos_desc' => "A class made up of characters who use protective spells.",
        'pos_dept' => 3,
        'pos_order' => 4,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Transmuter',
        'pos_desc' => "A class made up of characters who use Transmutation spells to change the properties of some creature, thing, or condition.",
        'pos_dept' => 3,
        'pos_order' => 5,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Conjurer',
        'pos_desc' => "A class made up of characters who use spells to bring manifestations of objects, creatures, or some form of energy.",
        'pos_dept' => 3,
        'pos_order' => 6,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Enchanter',
        'pos_desc' => "A class made up of characters who use Enchantment spells to affect the minds of others, influencing or controlling their behavior.",
        'pos_dept' => 3,
        'pos_order' => 7,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Cleric',
        'pos_desc' => "A class made up of characters who cast divine spells and are also capable in combat.",
        'pos_dept' => 4,
        'pos_order' => 0,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Druid',
        'pos_desc' => "A class made up of characters who draw energy from the natural world to cast divine spells and gain special magical powers.",
        'pos_dept' => 4,
        'pos_order' => 1,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Monk',
        'pos_desc' => "A class made up of characters who are masters of the martial arts and have a number of exotic powers.",
        'pos_dept' => 4,
        'pos_order' => 2,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Bard',
        'pos_desc' => "A class made up of performers whose music and poetics produce magical effects.",
        'pos_dept' => 5,
        'pos_order' => 0,
        'pos_open' => 2,
        'pos_type' => 'officer'),
    array(
        'pos_name' => 'Rogue',
        'pos_desc' => "A class made up of characters who primarily rely on stealth rather than brute force or magical ability.",
        'pos_dept' => 5,
        'pos_order' => 1,
        'pos_open' => 2,
        'pos_type' => 'officer'),
);

$catalogue_ranks = array(
    array(
        'rankcat_name' => 'Standard Ranks',
        'rankcat_location' => 'default',
        'rankcat_credits' => "The rank sets used in Nova were created by Anodyne Productions with assistance from Wade Duerkes. Please do not copy or modify the images.",
        'rankcat_default' => 'y',
        'rankcat_url' => 'http://anodyne-productions.com/',
        'rankcat_genre' => $g),
);
