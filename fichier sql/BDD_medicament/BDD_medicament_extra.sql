
--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis_ASMR`
--
ALTER TABLE `avis_ASMR`
  ADD PRIMARY KEY (`Identifiant`);

--
-- Index pour la table `avis_SMR`
--
ALTER TABLE `avis_SMR`
  ADD PRIMARY KEY (`Identifiant`);

--
-- Index pour la table `composants`
--
ALTER TABLE `composants`
  ADD PRIMARY KEY (`Code_substance`);

--
-- Index pour la table `cpd`
--
ALTER TABLE `cpd`
  ADD PRIMARY KEY (`code_CPD`);

--
-- Index pour la table `generique_medicament`
--
ALTER TABLE `generique_medicament`
  ADD PRIMARY KEY (`Id_grp_generique`);

--
-- Index pour la table `presentation`
--
ALTER TABLE `presentation`
  ADD PRIMARY KEY (`CodeCIP7`);

--
-- Index pour la table `specialite`
--
ALTER TABLE `specialite`
  ADD PRIMARY KEY (`CodeCIS`);
