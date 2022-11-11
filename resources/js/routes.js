import ListCard from "./components/cards/ListCard";
import CardRegister from "./components/cards/CardRegister";
import GenerateCard from "./components/cards/GenerateCard";

export const routes = [
    {
        name: 'home',
        path: '/',
        component: ListCard
    },
    {
        name: 'register',
        path: '/register',
        component: CardRegister
    },
    {
        name: 'generate',
        path: '/generate',
        component: GenerateCard
    }
]
