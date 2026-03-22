<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Politique de Confidentialité') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100 leading-relaxed">
                    
                    <h1 class="text-3xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Politique de Confidentialité</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">Dernière mise à jour : 16 mars 2026</p>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">1. Responsable du traitement</h2>
                        <p>Le site <strong>lakile.azzhy.com</strong> est édité par l'équipe Lakile, responsable du traitement des données personnelles collectées sur la plateforme.</p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">2. Données collectées</h2>
                        <ul class="list-disc ml-6 space-y-2">
                            <li><strong>Compte utilisateur :</strong> Nom, adresse email, mot de passe (haché via bcrypt).</li>
                            <li><strong>Données de paiement :</strong> Gérées via un prestataire tiers certifié PCI-DSS. Nous ne stockons aucune coordonnée bancaire sur nos serveurs.</li>
                            <li><strong>Données d'utilisation :</strong> Adresse IP, logs de connexion et rapports d'audit pour des raisons de sécurité.</li>
                        </ul>
                    </section>

                    <section class="mb-8 bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg border-l-4 border-indigo-500">
                        <h2 class="text-xl font-semibold mb-3 text-indigo-700 dark:text-indigo-300">3. Engagement "Zero-Knowledge"</h2>
                        <p>
                            Lakile utilise un chiffrement <strong>AES-256 côté client</strong>. Vos identifiants et mots de passe sont chiffrés avant d'atteindre nos serveurs. 
                            <strong>Techniquement, nous sommes dans l'incapacité de lire, récupérer ou réinitialiser vos secrets stockés dans votre coffre-fort.</strong>
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">4. Finalités du traitement</h2>
                        <p>Vos données sont traitées uniquement pour :</p>
                        <ul class="list-disc ml-6 mt-2 space-y-2">
                            <li>La fourniture et la gestion de votre espace sécurisé.</li>
                            <li>La sécurité de votre compte (alertes de connexion, détection de fuites).</li>
                            <li>L'envoi de communications liées au service (facturation, maintenance).</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">5. Durée de conservation</h2>
                        <p>
                            Vos données personnelles sont conservées tant que votre compte est actif. En cas de résiliation, vos données sont définitivement supprimées de nos bases de production sous un délai de 30 jours, à l'exception des documents comptables (factures) conservés selon les durées légales en vigueur.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">6. Vos droits (RGPD)</h2>
                        <p>
                            Conformément au Règlement Général sur la Protection des Données, vous disposez d'un droit d'accès, de rectification, de portabilité et d'effacement de vos données. Pour toute demande, vous pouvez nous contacter à : 
                            <a href="mailto:support@azzhy.com" class="text-indigo-500 hover:underline">support@azzhy.com</a>.
                        </p>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>