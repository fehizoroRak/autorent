<?php

namespace App\DataFixtures;

use App\Entity\CityDropoffLocation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityDropoffLocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cities = [
            'Paris,75', 'Marseille,13', 'Lyon,69', 'Toulouse,31', 'Nice,06', 'Nantes,44', 'Montpellier,34', 'Strasbourg,67', 'Bordeaux,33', 'Lille,59', 'Rennes,35', 'Toulon,83', 'Reims,51', 'Saint-Étienne,42', 'Le Havre,76', 'Dijon,21', 'Grenoble,38', 'Angers,49', 'Villeurbanne,69', 'Nîmes,30', 'Aix-en-Provence,13', 'Clermont-Ferrand,63', 'Le Mans,72', 'Brest,29', 'Tours,37', 'Amiens,80', 'Annecy,74', 'Limoges,87', 'Metz,57', 'Boulogne-Billancourt,92', 'Perpignan,66', 'Besançon,25', 'Orléans,45', 'Rouen,76', 'Saint-Denis,93', 'Montreuil,93', 'Caen,14', 'Argenteuil,95', 'Mulhouse,68', 'Nancy,54', 'Tourcoing,59', 'Roubaix,59', 'Nanterre,92', 'Vitry-sur-Seine,94', 'Créteil,94', 'Avignon,84', 'Poitiers,86', 'Aubervilliers,93', 'Asnières-sur-Seine,92', 'Colombes,92', 'Dunkerque,59', 'Aulnay-sous-Bois,93', 'Versailles,78', 'Courbevoie,92', 'Béziers,34', 'La Rochelle,17', 'Rueil-Malmaison,92', 'Cherbourg-en-Cotentin,50', 'Champigny-sur-Marne,94', 'Pau,64', 'Mérignac,33', 'Saint-Maur-des-Fossés,94', 'Antibes,06', 'Ajaccio,2A', 'Cannes,06', 'Saint-Nazaire,44', 'Drancy,93', 'Noisy-le-Grand,93', 'Issy-les-Moulineaux,92', 'Cergy,95', 'Levallois-Perret,92', 'Colmar,68', 'Calais,62', 'Pessac,33', 'Vénissieux,69', 'Évry-Courcouronnes,91', 'Clichy,92', 'Valence,26', 'Ivry-sur-Seine,94', 'Bourges,18', 'Quimper,29', 'Antony,92', 'Troyes,10', 'La Seyne-sur-Mer,83', 'Villeneuve-d\'Ascq,59', 'Montauban,82', 'Pantin,93', 'Chambéry,73', 'Niort,79', 'Neuilly-sur-Seine,92', 'Sarcelles,95', 'Le Blanc-Mesnil,93', 'Maisons-Alfort,94', 'Lorient,56', 'Villejuif,94', 'Fréjus,83', 'Beauvais,60', 'Narbonne,11', 'Meaux,77', 'Hyères,83', 'Bobigny,93', 'La Roche-sur-Yon,85', 'Clamart,92', 'Vannes,56', 'Chelles,77', 'Cholet,49', 'Épinay-sur-Seine,93', 'Saint-Ouen-sur-Seine,93', 'Saint-Quentin,02', 'Bondy,93', 'Bayonne,64', 'Corbeil-Essonnes,91', 'Cagnes-sur-Mer,06', 'Vaulx-en-Velin,69', 'Sevran,93', 'Fontenay-sous-Bois,94', 'Sartrouville,78', 'Massy,91', 'Arles,13', 'Albi,81', 'Laval,53', 'Saint-Herblain,44', 'Gennevilliers,92', 'Suresnes,92', 'Saint-Priest,69', 'Vincennes,94', 'Bastia,2B', 'Martigues,13', 'Les Sables-d\'Olonne,85', 'Grasse,06', 'Montrouge,92', 'Aubagne,13', 'Saint-Malo,35', 'Évreux,27', 'La Courneuve,93', 'Blois,41', 'Brive-la-Gaillarde,19', 'Charleville-Mézières,08', 'Meudon,92', 'Carcassonne,11', 'Choisy-le-Roi,94', 'Noisy-le-Sec,93', 'Livry-Gargan,93', 'Rosny-sous-Bois,93', 'Talence,33', 'Belfort,90', 'Alfortville,94', 'Chalon-sur-Saône,71', 'Salon-de-Provence,13', 'Sète,34', 'Istres,13', 'Mantes-la-Jolie,78', 'Saint-Germain-en-Laye,78', 'Saint-Brieuc,22', 'Tarbes,65', 'Alès,30', 'Châlons-en-Champagne,51', 'Bagneux,92', 'Puteaux,92', 'Caluire-et-Cuire,69', 'Bron,69', 'Rezé,44', 'Valenciennes,59', 'Châteauroux,36', 'Garges-lès-Gonesse,95', 'Castres,81', 'Arras,62', 'Melun,77', 'Thionville,57', 'Le Cannet,06', 'Bourg-en-Bresse,01', 'Anglet,64', 'Angoulême,16', 'Boulogne-sur-Mer,62', 'Wattrelos,59', 'Gap,05', 'Villenave-d\'Ornon,33', 'Montélimar,26', 'Compiègne,60', 'Stains,93', 'Gagny,93', 'Colomiers,31', 'Poissy,78', 'Draguignan,83', 'Douai,59', 'Bagnolet,93', 'Marcq-en-Baroeul,59', 'Villepinte,93', 'Saint-Martin-d\'Hères,38', 'Chartres,28', 'Pontault-Combault,77', 'Joué-lès-Tours,37', 'Annemasse,74', 'Neuilly-sur-Marne,93', 'Franconville,95', 'Savigny-sur-Orge,91', 'Tremblay-en-France,93', 'Thonon-les-Bains,74', 'La Ciotat,13', 'Échirolles,38', 'Châtillon,92', 'Athis-Mons,91', 'Six-Fours-les-Plages,83', 'Creil,60', 'Saint-Raphaël,83', 'Conflans-Sainte-Honorine,78', 'Villefranche-sur-Saône,69', 'Meyzieu,69', 'Sainte-Geneviève-des-Bois,91', 'Haguenau,67', 'Vitrolles,13', 'Villeneuve-Saint-Georges,94', 'Saint-Chamond,42', 'Châtenay-Malabry,92', 'Palaiseau,91', 'Auxerre,89', 'Roanne,42', 'Mâcon,71', 'Le Perreux-sur-Marne,94', 'Schiltigheim,67', 'Les Mureaux,78', 'Trappes,78', 'Nogent-sur-Marne,94', 'Houilles,78', 'Montluçon,03', 'Romainville,93', 'Marignane,13', 'Romans-sur-Isère,26', 'Nevers,58', 'Lens,62', 'Saint-Médard-en-Jalles,33', 'Agen,47', 'Pierrefitte-sur-Seine,93', 'Épinal,88', 'Bezons,95', 'Aix-les-Bains,73', 'Montigny-le-Bretonneux,78', 'Herblay-sur-Seine,95', 'Cambrai,59', 'L\'Haÿ-les-Roses,94', 'Plaisir,78', 'Pontoise,95', 'Châtellerault,86', 'Rillieux-la-Pape,69', 'Thiais,94', 'Vienne,38', 'Vigneux-sur-Seine,91', 'Viry-Châtillon,91', 'Saint-Laurent-du-Var,06', 'Le Chesnay-Rocquencourt,78', 'Dreux,28', 'Bègles,33', 'Carpentras,84', 'Goussainville,95', 'Mont-de-Marsan,40', 'Villiers-sur-Marne,94', 'Cachan,94', 'Savigny-le-Temple,77', 'Menton,06', 'Villemomble,93', 'Malakoff,92', 'Liévin,62', 'La Garenne-Colombes,92', 'Ris-Orangis,91', 'Bois-Colombes,92', 'Clichy-sous-Bois,93', 'Décines-Charpieu,69', 'Saint-Cloud,92', 'Chatou,78', 'Bourgoin-Jallieu,38', 'Vandoeuvre-lès-Nancy,54', 'Périgueux,24', 'Charenton-le-Pont,94', 'Tournefeuille,31', 'Guyancourt,78', 'Le Plessis-Robinson,92', 'Draveil,91', 'Agde,34', 'Maubeuge,59', 'Ermont,95', 'Sotteville-lès-Rouen,76', 'Orange,84', 'Villiers-le-Bel,95', 'Fresnes,94', 'Soissons,02', 'Yerres,91', 'Saint-Étienne-du-Rouvray,76', 'Dieppe,76', 'Saint-Sébastien-sur-Loire,44', 'Vallauris,06', 'Vanves,92', 'Limeil-Brévannes,94', 'Montfermeil,93', 'Orvault,44', 'Sucy-en-Brie,94', 'Grigny,91', 'Lambersart,59', 'Illkirch-Graffenstaden,67', 'Oullins,69', 'Brétigny-sur-Orge,91', 'Sens,89', 'Taverny,95', 'Villeparisis,77', 'Rambouillet,78', 'Cenon,33', 'Sannois,95', 'Cormeilles-en-Parisis,95', 'Bussy-Saint-Georges,77', 'La Teste-de-Buch,33', 'Étampes,91', 'Blagnac,31', 'Miramas,13', 'Bergerac,24', 'Saumur,49', 'Lunel,34', 'Élancourt,78', 'Hénin-Beaumont,62', 'Vertou,44', 'Le Grand-Quevilly,76', 'Gonesse,95', 'Cavaillon,84', 'La Garde,83', 'Gradignan,33', 'Aurillac,15', 'Sèvremoine,49', 'Vichy,03', 'Biarritz,64', 'Champs-sur-Marne,77', 'Armentières,59', 'Montbéliard,25', 'Alençon,61', 'Saintes,17', 'Brunoy,91', 'Eaubonne,95', 'Villeneuve-la-Garenne,92', 'Vierzon,18', 'Les Ulis,91', 'Muret,31', 'Saint-Ouen-l\'Aumône,95', 'Béthune,62', 'Castelnau-le-Lez,34', 'Fontenay-aux-Roses,92', 'Libourne,33', 'Vernon,27', 'Orly,94', 'Le Kremlin-Bicêtre,94', 'Eysines,33', 'Le Bouscat,33', 'Rodez,12', 'Les Pavillons-sous-Bois,93', 'Laon,02', 'La Valette-du-Var,83', 'Frontignan,34', 'Montgeron,91', 'Dole,39', 'Beaupréau-en-Mauges,49', 'Les Lilas,93', 'Lormont,33', 'Rochefort,17', 'Maisons-Laffitte,78', 'Saint-Dizier,52', 'Roissy-en-Brie,77', 'Couëron,44', 'Auch,32', 'Lanester,56', 'Loos,59', 'Manosque,04', 'Fontaine,38', 'Olivet,45', 'Dammarie-les-Lys,77', 'Vélizy-Villacoublay,78', 'Saint-Louis,68', 'Tassin-la-Demi-Lune,69', 'Sèvres,92', 'Montigny-lès-Cormeilles,95', 'Abbeville,80', 'Deuil-la-Barre,95', 'Challans,85', 'La Madeleine,59', 'Torcy,77', 'Gujan-Mestras,33', 'Gif-sur-Yvette,91', 'Oyonnax,01', 'Montereau-Fault-Yonne,77', 'Combs-la-Ville,77', 'Hérouville-Saint-Clair,14', 'Les Pennes-Mirabeau,13', 'Épernay,51', 'Montmorency,95', 'Sainte-Foy-lès-Lyon,69', 'Montigny-lès-Metz,57', 'Bruay-la-Buissière,62', 'Le Petit-Quevilly,76', 'Millau,12', 'Saint-Jean-de-Braye,45', 'Chaumont,52', 'Villeneuve-sur-Lot,47', 'Mandelieu-la-Napoule,06', 'Arcueil,94', 'Hazebrouck,59'
        ];

        foreach ($cities as $cityName) {
            $city = new CityDropoffLocation();
            $city->setName($cityName);
            $manager->persist($city);
        }

        $manager->flush();
    }
}
