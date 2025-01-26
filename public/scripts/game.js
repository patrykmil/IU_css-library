class Game {
    constructor() {
        this.string = document.querySelector('.game-string');
        this.tiles = document.querySelectorAll('.tile');
        this.button = document.querySelector('.start');
        this.state = new BeforeGame();
        this.init();
        this.answer = [];
    }

    init() {
        this.button.addEventListener('click', () => this.state.handle(this, []));
    }

    updateDescription(butt, seq, desc) {
        this.string.innerHTML = desc || `Current streak: ${seq.length - 1}`;
        this.button.innerHTML = butt || 'Start';
    }

    showSequence(sequence) {
        sequence.push(this.getRandomTile());
        sequence.forEach((tile, index) => {
            setTimeout(() => {
                tile.classList.add('active');
                setTimeout(() => {
                    tile.classList.remove('active');
                }, 500);
            }, index * 1000);
        });
        return sequence;
    }

    getRandomTile() {
        const randomIndex = Math.floor(Math.random() * this.tiles.length);
        return this.tiles[randomIndex];
    }

    getAnswer(tile, sequence) {
        this.answer.push(tile);
        let correct = false;
        if (this.answer.length < sequence.length)
            return
        correct = this.checkAnswer(this.answer, sequence);
        if (correct) {
            this.updateDescription('Next', sequence, `Current streak: ${sequence.length}`);
            this.button.onclick = () => {
                this.state = new ShowSequence();
                this.state.handle(this, sequence);
            };
        } else {
            this.updateDescription('Restart', sequence);
            this.button.onclick = () => {
                this.state = new BeforeGame();
                this.state.handle(this, sequence);
            }
        }
    }

    checkAnswer(answer, sequence) {
        if (answer.length !== sequence.length) {
            return false;
        }
        for (let i = 0; i < answer.length; i++) {
            if (answer[i] !== sequence[i]) {
                return false;
            }
        }
        return true;
    }
}

class GameState {
    handle(context, sequence) {
        throw new Error('Method "handle()" must be implemented.');
    }
}

class BeforeGame extends GameState {
    handle(context, sequence) {
        sequence = [];
        context.updateDescription('...', sequence);
        context.state = new ShowSequence();
        context.state.handle(context, sequence);
    }
}

class ShowSequence extends GameState {
    handle(context, sequence) {
        context.answer = [];
        context.updateDescription('...', sequence);
        sequence = context.showSequence(sequence);
        context.state = new SubmitAnswer();
        context.state.handle(context, sequence);
    }
}

class SubmitAnswer extends GameState {
    handle(context, sequence) {
        context.updateDescription('Answer', sequence);
        context.tiles.forEach(tile => {
            tile.onclick = () => {
                context.getAnswer(tile, sequence);
            };
        });
    }
}


document.addEventListener('DOMContentLoaded', () => {
    const game = new Game();
});