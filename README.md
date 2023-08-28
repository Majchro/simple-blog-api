Etapy powstawania projektu (od czego zaczęto pracę, jak została ona podzielona?)
- przygotowanie projektu z użyciem własnej laravelowej templatki i dostosowanie go do potrzeb
- rozpisanie modelów, tabel, relacji i funkcjonalności
- przemyślenie sposobu uwierzytelniania użytkowników(wybór padł na `cookie-based authentication`)
- napisanie logiki + testów
- użycie `Laravel Pint` w celu poprawienia/ujednolicenia standardu kodu

Z jakimi częściami miałeś /miałaś problem i dlaczego?
- miałem problem z repozytoriami, w Laravelu uważam je za zbędne szczególnie w takiej małej aplikacji

Które części uważasz że można by lepiej dopracować gdybyś miał/a więcej czasu?
- przemyślałbym lepszy system ról żeby nie musieć poprawiać autoryzacji w wielu miejscach np. po dodaniu nowej roli
- dodałbym obsługę kompresji plików graficznych dodawanych do postów
- dodałbym managera gitowych hooków jak `husky` lub `lefthook` do weryfikowania kodu przy commitowaniu/pushowaniu
