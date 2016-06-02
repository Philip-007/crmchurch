SET @upgradeStartTime = NOW();

ALTER TABLE `version_ver`
CHANGE COLUMN `ver_date` `ver_update_start` datetime default NULL;

ALTER TABLE `version_ver`
ADD COLUMN `ver_update_end` datetime default NULL AFTER `ver_update_start`;

-- ------ Notes #608 - start

ALTER TABLE note_nte
  ADD COLUMN nte_Type VARCHAR(45) NOT NULL DEFAULT 'note' AFTER nte_EditedBy;

INSERT INTO note_nte
	(nte_per_ID, nte_fam_ID, nte_Private, nte_Text, nte_EnteredBy, nte_DateEntered, nte_Type)
select per_id, 0, 0, "", per_EnteredBy, per_DateEntered, "create"
from person_per;

INSERT INTO note_nte
	(nte_per_ID, nte_fam_ID, nte_Private, nte_Text, nte_EnteredBy, nte_DateEntered, nte_Type)
select per_id, 0, 0, "", per_EditedBy, per_DateLastEdited, "edit"
from person_per
where per_DateLastEdited is not null;

-- ------ Notes #608 - end


INSERT IGNORE INTO version_ver (ver_version, ver_update_start, ver_update_end) VALUES ('2.1.0',@upgradeStartTime,NOW());
