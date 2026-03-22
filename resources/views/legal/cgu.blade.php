<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Conditions Générales d’Utilisation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100 leading-relaxed">
                    
                    <h1 class="text-3xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Conditions Générales d’Utilisation</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">En vigueur au 16 mars 2026</p>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">1. Objet du service</h2>
                        <p>Lakile est un service de coffre-fort numérique chiffré destiné aux entreprises. Le service permet le stockage, le partage et la gestion d'identifiants de manière sécurisée.</p>
                    </section>

                    <section class="mb-8 bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border-l-4 border-red-500">
                        <h2 class="text-xl font-semibold mb-3 text-red-700 dark:text-red-400">2. Responsabilité de l'utilisateur (Mot de passe Maître)</h2>
                        <p class="font-bold">Attention : Architecture Zero-Knowledge</p>
                        <p class="mt-2">
                            L'accès à votre coffre-fort est protégé par un "Mot de passe Maître" connu de vous seul. 
                            <strong>Lakile ne stocke pas ce mot de passe et n'a aucun moyen de le réinitialiser.</strong>
                        </p>
                        <p class="mt-2">
                            En cas de perte de votre mot de passe maître, l'accès à vos données chiffrées sera définitivement perdu. Lakile ne pourra être tenu responsable de la perte de données résultant de l'oubli de vos identifiants d'accès.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">3. Disponibilité du service</h2>
                        <p>
                            Nous nous efforçons d'assurer une disponibilité du service de 99,9%. Toutefois, nous nous réservons le droit d'interrompre le service pour des opérations de maintenance programmées ou en cas de force majeure.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">4. Propriété intellectuelle</h2>
                        <p>
                            L'interface, le logo, le design et les algorithmes de Lakile sont la propriété exclusive de l'éditeur. Toute reproduction est interdite sans accord préalable.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">5. Résiliation</h2>
                        <p>
                            L'utilisateur peut résilier son abonnement à tout moment depuis son espace client. En cas de non-paiement ou de violation des présentes CGU, Lakile se réserve le droit de suspendre l'accès au service après mise en demeure restée infructueuse.
                        </p>
                    </section>

                    <section class="mb-8 border-t border-gray-200 dark:border-gray-700 pt-6 text-center">
                        <p class="text-sm">
                            Pour toute question relative aux CGU : 
                            <a href="mailto:legal@azzhy.com" class="text-indigo-500 hover:underline">legal@azzhy.com</a>
                        </p>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>