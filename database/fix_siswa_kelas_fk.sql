ALTER TABLE `siswa` DROP FOREIGN KEY `siswa_ibfk_1`;

UPDATE `siswa` s
LEFT JOIN `kelas` k ON k.id = s.kelas_id
SET s.kelas_id = NULL
WHERE s.kelas_id IS NOT NULL AND k.id IS NULL;

ALTER TABLE `siswa` DROP FOREIGN KEY `siswa_kelas_fk`;

ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_kelas_fk` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL;
