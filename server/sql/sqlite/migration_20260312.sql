CREATE TABLE IF NOT EXISTS settings (
	id INTEGER NOT NULL PRIMARY KEY,
	user INTEGER NOT NULL REFERENCES users (id) ON DELETE CASCADE,
	scope TEXT NOT NULL,
	deviceid TEXT NULL,
	podcast TEXT NULL,
	episode TEXT NULL,
	name TEXT NOT NULL,
	value TEXT NOT NULL,
	changed INTEGER NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS settings_unique ON settings (user, scope, deviceid, podcast, episode, name);
CREATE INDEX IF NOT EXISTS settings_user_scope ON settings (user, scope);
