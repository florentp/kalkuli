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
<ul id="menu">
	<li><a href="#" id="menuHome">Accueil</a></li>
	<li><a href="#" id="howItWorks">Comment ça marche&nbsp;?</a></li>
	<li><a href="#" id="menuFaq">FAQ</a></li>
	{if $TESTS_SITE}
		<img id="testsStamp" alt="Tests" height="38" src="{$CONTEXT_PATH}/images/tests-stamp.png" title="Site de tests. Les données peuvent être effacées à n'importe quel moment." width="74" />
	{/if}
</ul>
{literal}
<script type="text/javascript">
	$(function() {
		$('#menu').addClass('ui-helper-clearfix ui-state-default');
		
		$('#menu > li').hover(
			function() { $(this).addClass('ui-state-hover'); },
			function() { $(this).removeClass('ui-state-hover'); }
		);
		
		$('#menuHome').click(function() {
			$.doGet(CONTEXT_PATH + '/');
			return false;
		});
		$('#howItWorks').click(function() {
			$.doGet(CONTEXT_PATH + '/howItWorks');
			return false;
		});
		$('#menuFaq').click(function() {
			$.doGet(CONTEXT_PATH + '/faq');
			return false;
		});
	});
</script>
{/literal}
