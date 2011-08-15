{*
 * Copyright 2006-2011 Florent Paillard
 * 
 * This file is part of /kal.'ku.li/.
 * 
 * /kal.'ku.li/ is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * /kal.'ku.li/ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with /kal.'ku.li/.  If not, see <http://www.gnu.org/licenses/>.
 * 
 *}
<h1>Principes de base du fonctionnement de /kal.'ku.li/</h1>
<div class="ui-main-widget">
	<div class="ui-main-widget-content">
		<h2>Création d'une feuille de compte</h2>
		<p>Que se soit pour faire les comptes d'une soirée, de vacances, d'une colocation ou autre, vous créez une <span class="alternate">feuille de compte</span> depuis la page d'accueil. Une feuille de compte est un espace privé dans lequel vous enregistrez le nom des <span class="alternate">participants</span> et saisissez l'ensemble des dépenses, appelées <span class="alternate">opérations</span>, effectuées par et pour les participants.</p>
		<h2>Enregistrement des opérations et calcul du solde</h2>
		<p>Au fur et à mesure que vous saisissez des opérations (généralement des dépenses), le <span class="alternate">solde</span> de chaque participant est mis à jour. Lorsqu'un participant a un solde positif, ceci signifie qu'il a dépensé plus que les autres participants. Et inversement.</p>
		<p>Par exemple, lorsqu'une opération de 30&nbsp;&euro; est enregistrée et réparties entre 3 participants, le solde de celui qui a réglé la dépense augmente de 20&nbsp;&euro; (+30&nbsp;&euro; réglés, -10&nbsp;&euro; représentant sa propre part) et le solde des deux autres participants diminue de 10&nbsp;&euro;.</p>
		<p>Remarque: la somme des soldes des participants d'une feuille de compte est toujours égale à zéro.</p>
		<h2>Répartition et pondération des opérations</h2>
		<p>Par défaut, les opérations s'appliquent à tous les participants de la feuille de compte mais il est possible de sélectionner uniquement les participants concernés par une opération.</p>
		<p>Il est également possible de saisir des opérations réglées par plusieurs participants, appelés <span class="alternate">contributeurs</span>. Le montant total de l'opération est donc égal à la somme des réglements. Ce montant total est ensuite réparti entre les participants sélectionnés pour cette opération.</p>
		<p>Enfin, il est possible de répartir le montant total d'une opération de manière pondérée entre les participants en leur appliquant des quota différents, appelés <span class="alternate">parts</span>.</p>
		<h2>Finalisation des comptes et remboursements</h2>
		<p>Lorsque toutes les opérations ont été saisies, le solde de tous les participants n'est généralement pas à 0. Les participants ayant un solde négatif doivent donc rembourser ceux qui ont un solde positif. Il n'y a pas de règle déterminant quel participant remboursera quel autre. Cette décision est généralement prise en essayant de réduire le nombre de remboursement à effectuer.</p>
		<p>Cette étape de remboursement se produit généralement pour les compte de soirée, vacances ou évènement relativement court. A l'inverse, dans une collocation, l'écran présentant le solde des participants est plutôt utilisé pour savoir quel collocataire va payer la prochaine facture afin de ré-équilibrer le solde de chacun même si le zéro absolu n'est quasiment jamais atteint.</p>
		<p>Pour saisir un remboursement, il suffit de créer une opération du montant du remboursement ayant un seul contributeur (celui qui rembourse) et un seul participant (celui qui est remboursé). Le solde du contributeur augmente alors exactement de la valeur du remboursement et celui du participant dimune d'autant.</p>
	</div>
</div>
