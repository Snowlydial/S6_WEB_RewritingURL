CREATE TABLE article(
   id_article INT AUTO_INCREMENT,
   title VARCHAR(255) ,
   slug VARCHAR(255) ,
   content TEXT,
   summary VARCHAR(500) ,
   created_at DATETIME,
   authors TEXT,
   cover TEXT,
   PRIMARY KEY(id_article)
);

CREATE TABLE role(
   id_role INT AUTO_INCREMENT,
   label VARCHAR(50) ,
   PRIMARY KEY(id_role)
);

CREATE TABLE user(
   id_user INT AUTO_INCREMENT,
   username VARCHAR(50) ,
   password VARCHAR(255) ,
   id_role INT NOT NULL,
   PRIMARY KEY(id_user),
   FOREIGN KEY(id_role) REFERENCES role(id_role)
);

INSERT INTO role (label) VALUES ('admin'), ('subscriber'), ('guest');

INSERT INTO user (username, password, id_role) VALUES 
('admin', 'admin', 1),
('xyz', 'xyz', 3);

INSERT INTO article (title, slug, content, summary, created_at, authors) VALUES
('Iran: tensions in the Gulf rise after night strikes',
 'iran-tensions-in-the-gulf-rise-after-night-strikes',
 '<p>After a tense night in the Gulf area, regional actors are reviewing security measures and diplomatic channels. Officials reported a series of incidents that raised concerns over maritime routes and civilian safety.</p><p>Analysts say the coming days will be decisive for de-escalation talks.</p>',
 'After incidents in the Gulf, officials and analysts focus on de-escalation and regional security.',
 '2026-03-30 07:45:00',
 'Pierre Bouvier'),

('Live update: negotiations continue in Tehran',
 'live-update-negotiations-continue-in-tehran',
 '<p>Delegations met again in Tehran to continue indirect talks. Sources close to the process described the atmosphere as "cautious but constructive".</p><p>No final agreement has been announced yet.</p>',
 'Delegations continue talks in Tehran, with cautious progress but no final agreement yet.',
 '2026-03-30 09:10:00',
 'Gabriel Coutagne'),

('Editorial: the strategic trap of escalation',
 'editorial-the-strategic-trap-of-escalation',
 '<p>Escalation may look like strength in the short term, but it often narrows diplomatic options. The current sequence shows how quickly tactical moves can produce strategic dead ends.</p>',
 'Escalation can create long-term strategic costs and reduce diplomatic room for all sides.',
 '2026-03-29 18:20:00',
 'Le Monde'),

('Nuclear file: what changed this month',
 'nuclear-file-what-changed-this-month',
 '<p>This month brought technical updates, revised timelines, and renewed inspections discussions. Experts warn that interpretation gaps remain a major obstacle.</p>',
 'Key updates in the nuclear file include timelines, inspections, and persistent interpretation gaps.',
 '2026-03-28 12:00:00',
 'Nina Rahimi'),

('Field report: life in border towns under pressure',
 'field-report-life-in-border-towns-under-pressure',
 '<p>In several border towns, daily routines continue under visible pressure. Schools and shops stay open, but residents describe uncertainty as the new normal.</p>',
 'Residents in border towns maintain daily life while facing uncertainty and security pressure.',
 '2026-03-27 16:35:00',
 'Samir Haddad'),

('Analysis: shipping lanes and economic risk',
 'analysis-shipping-lanes-and-economic-risk',
 '<p>Shipping disruptions can rapidly affect fuel prices and supply chains. Economists estimate that even short incidents can create measurable volatility across markets.</p>',
 'Short disruptions in shipping lanes can trigger fuel price and supply chain volatility.',
 '2026-03-26 10:05:00',
 'Claire Martin'),

('Interview: a diplomat on red lines and dialogue',
 'interview-a-diplomat-on-red-lines-and-dialogue',
 '<p>In this interview, a former diplomat explains how red lines are communicated behind closed doors and why public messaging can differ from private negotiation signals.</p>',
 'A former diplomat explains red lines, private signals, and the logic of high-stakes dialogue.',
 '2026-03-25 14:50:00',
 'Omar Nader'),

('Timeline: from incident to emergency talks in 72 hours',
 'timeline-from-incident-to-emergency-talks-in-72-hours',
 '<p>Hour by hour, this timeline tracks the sequence from first reports to emergency meetings. Multiple capitals coordinated statements while military and diplomatic channels stayed active.</p>',
 'A 72-hour timeline of events leading from initial incident to emergency diplomatic talks.',
 '2026-03-24 08:30:00',
 'Editorial Desk'),

('Data focus: public sentiment trends this quarter',
 'data-focus-public-sentiment-trends-this-quarter',
 '<p>Survey data shows polarized opinions but a stable majority in favor of negotiated outcomes. Younger groups report stronger support for regional cooperation initiatives.</p>',
 'Survey trends show polarization, yet steady support for negotiated outcomes and cooperation.',
 '2026-03-23 11:25:00',
 'Data Team'),

('Weekend brief: five points to watch next week',
 'weekend-brief-five-points-to-watch-next-week',
 '<p>From diplomatic calendars to energy indicators, here are five signals likely to shape headlines next week. The brief highlights both risk factors and possible stabilizers.</p>',
 'Five key signals to monitor next week across diplomacy, energy, and regional stability.',
 '2026-03-22 19:40:00',
 'Weekend Desk');