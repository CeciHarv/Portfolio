using Speed.Shared.Models;
using Microsoft.AspNetCore.SignalR;
using System.Text.Json;
using System.Collections.Concurrent;

namespace Speed.Server.Engine
{
    public class SpeedEngine
    {

        //private static readonly ConcurrentBag<GameEngine> games = new ConcurrentBag<GameEngine>();
        public static GameEngine game;

        public SpeedEngine()
        {
            game = new GameEngine();
        }

        public async Task DealDeck(Hub hub)
        {

            if (game is null)
            {
                Console.WriteLine("The game is null");
                return;
            }

            await hub.Clients.All.SendAsync("ReceiveDeck", "test2", game.Deck);

        }

        public async Task RequestDeck(Hub hub)
        {


            if (game is null)
            {
                Console.WriteLine("The game is null");
                return;
            }

            var cardList = game.Deck.getCards();
            await hub.Clients.All.SendAsync("ReceiveDeck", game.Deck.GetHashCode().ToString(), cardList);

        }

        public async Task RequestHand(Hub hub, bool playerOne)
        {

            Console.WriteLine("We are at the speedengine");
            if (playerOne)
            {
                await hub.Clients.Caller.SendAsync("ReceiveHand", game.P1Hand);
            }
            else
            {
                await hub.Clients.Caller.SendAsync("ReceiveHand", game.P2Hand);
            }
        }

        public async Task RequestGame(Hub hub)
        {
            int P1NumDeck = game.P1Draw.Count;
            int P2NumDeck = game.P2Draw.Count;
            await hub.Clients.All.SendAsync("ReceiveGame", game.P1Draw, game.P2Draw, game.Mid1Draw, game.Mid2Draw, game.Mid1Discard, game.Mid2Discard, game.P1Hand, game.P2Hand);
            await hub.Clients.All.SendAsync("ReceiveDeckandHand", game.P1Hand, game.P2Hand, P1NumDeck, P2NumDeck);
        }

        //Players click on a card in there hand
        public async Task SetSelectedCard(Hub hub, Card selectedCard, bool playerOne)
        {
            if (playerOne)
            {
                game.GameService.onHandClick1(selectedCard);
            }
            else
            {
                game.GameService.onHandClick2(selectedCard);
            }
            await hub.Clients.All.SendAsync("ReceiveSelectedCards", game.P1Hand, game.P2Hand);
        }

        //Players click on middle discard with a selected card(update middle and players hand
        public async Task OnMiddleClick(Hub hub, List<Card> middleDeck, string midNum)
        {
            Card midCard = middleDeck[0];
            game.GameService.onPlay(middleDeck, midNum);
            if (midNum == "one")
            {
                await hub.Clients.All.SendAsync("ReceiveMiddleDeck", game.Mid1Discard, game.P1Hand, game.P2Hand, "one", game.GameService.p1Won, game.GameService.p2Won);
            }
            else
            {
                await hub.Clients.All.SendAsync("ReceiveMiddleDeck", game.Mid2Discard, game.P1Hand, game.P2Hand, "two", game.GameService.p1Won, game.GameService.p2Won);
            }
        }

        //Players click to add card to hand
        public async Task OnMoreCards(Hub hub, bool playerOne)
        {
            int P1NumDeck;
            int P2NumDeck;
            if (playerOne)
            {
                game.GameService.addCards1();
            }
            else
            {
                game.GameService.addCards2();  
            }
            P1NumDeck = game.P1Draw.Count;
            P2NumDeck = game.P2Draw.Count;
            await hub.Clients.All.SendAsync("ReceiveDeckandHand", game.P1Hand, game.P2Hand, P1NumDeck, P2NumDeck);
        }

        //Move outer middle to inner middle deck
        public async Task OnOuterMiddle(Hub hub, bool playerOne)
        {
            if (playerOne)
            {
                game.GameService.moveMiddle("one");
            }
            else
            {
                game.GameService.moveMiddle("two");
            }
            await hub.Clients.All.SendAsync("ReceiveMiddleDecks", game.Mid1Discard, game.Mid2Discard, game.Mid1Draw, game.Mid2Draw);
        }

        public async Task NewGameHighlight(Hub hub, bool playerOne)
        {
            if(playerOne)
            {
                game.p1NewGame = "0px 12px 22px 1px #00FF00;";
            }
            else
            {
                game.p2NewGame = "0px 12px 22px 1px #00FF00;";
            }
            await hub.Clients.All.SendAsync("ReceiveNewGameHighlight", game.p1NewGame, game.p2NewGame);
        }


        public void Shuffle(List<Card> cardPile)
        {
            Random rng = new Random();
            int size = cardPile.Count();
            while (size > 1)
            {
                size--;
                int swapSpot = rng.Next(size + 1);
                Card a = cardPile[swapSpot];
                cardPile[swapSpot] = cardPile[size];
                cardPile[size] = a;
            }
        }


    }
}

