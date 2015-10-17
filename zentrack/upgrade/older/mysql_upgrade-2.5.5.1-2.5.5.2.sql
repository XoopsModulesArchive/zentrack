## This script updates ZentrackXoops database from version 2.5.5.1 to 2.5.5.2

-- Modify the version number
UPDATE zentrack_settings SET value='2.5.5.2' WHERE setting_id=74;

