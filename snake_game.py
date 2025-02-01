import pygame
import random
import sys
from pygame.math import Vector2

# Initialize Pygame
pygame.init()

# Constants
CELL_SIZE = 40
CELL_NUMBER = 15
SCREEN_SIZE = CELL_SIZE * CELL_NUMBER

# Colors
BACKGROUND_COLOR = (40, 40, 40)
SNAKE_COLOR = (0, 255, 0)
FOOD_COLOR = (255, 0, 0)
TEXT_COLOR = (255, 255, 255)

# Setup the main window
screen = pygame.display.set_mode((SCREEN_SIZE, SCREEN_SIZE))
pygame.display.set_caption('Snake Game')
clock = pygame.time.Clock()

class Snake:
    def __init__(self):
        self.body = [Vector2(7, 7), Vector2(6, 7), Vector2(5, 7)]
        self.direction = Vector2(1, 0)
        self.new_block = False

    def draw(self):
        for block in self.body:
            block_rect = pygame.Rect(block.x * CELL_SIZE, block.y * CELL_SIZE, CELL_SIZE, CELL_SIZE)
            pygame.draw.rect(screen, SNAKE_COLOR, block_rect)

    def move(self):
        if self.new_block:
            body_copy = self.body[:]
            body_copy.insert(0, body_copy[0] + self.direction)
            self.body = body_copy
            self.new_block = False
        else:
            body_copy = self.body[:-1]
            body_copy.insert(0, body_copy[0] + self.direction)
            self.body = body_copy

    def grow(self):
        self.new_block = True

class Food:
    def __init__(self):
        self.randomize()

    def draw(self):
        food_rect = pygame.Rect(self.pos.x * CELL_SIZE, self.pos.y * CELL_SIZE, CELL_SIZE, CELL_SIZE)
        pygame.draw.rect(screen, FOOD_COLOR, food_rect)

    def randomize(self):
        self.x = random.randint(0, CELL_NUMBER - 1)
        self.y = random.randint(0, CELL_NUMBER - 1)
        self.pos = Vector2(self.x, self.y)

class Game:
    def __init__(self):
        self.snake = Snake()
        self.food = Food()
        self.score = 0
        self.font = pygame.font.Font(None, 36)

    def update(self):
        self.snake.move()
        self.check_collision()
        self.check_fail()

    def draw(self):
        screen.fill(BACKGROUND_COLOR)
        self.food.draw()
        self.snake.draw()
        self.draw_score()
        pygame.display.update()

    def check_collision(self):
        if self.food.pos == self.snake.body[0]:
            self.food.randomize()
            self.snake.grow()
            self.score += 1

    def check_fail(self):
        # Check if snake hits walls
        if not 0 <= self.snake.body[0].x < CELL_NUMBER or not 0 <= self.snake.body[0].y < CELL_NUMBER:
            self.game_over()

        # Check if snake hits itself
        for block in self.snake.body[1:]:
            if block == self.snake.body[0]:
                self.game_over()

    def game_over(self):
        pygame.quit()
        sys.exit()

    def draw_score(self):
        score_text = self.font.render(f'Score: {self.score}', True, TEXT_COLOR)
        screen.blit(score_text, (10, 10))

def main():
    game = Game()
    SCREEN_UPDATE = pygame.USEREVENT
    pygame.time.set_timer(SCREEN_UPDATE, 150)  # Game speed (lower = faster)

    while True:
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                pygame.quit()
                sys.exit()
            if event.type == SCREEN_UPDATE:
                game.update()
            if event.type == pygame.KEYDOWN:
                if event.key == pygame.K_UP and game.snake.direction.y != 1:
                    game.snake.direction = Vector2(0, -1)
                if event.key == pygame.K_DOWN and game.snake.direction.y != -1:
                    game.snake.direction = Vector2(0, 1)
                if event.key == pygame.K_LEFT and game.snake.direction.x != 1:
                    game.snake.direction = Vector2(-1, 0)
                if event.key == pygame.K_RIGHT and game.snake.direction.x != -1:
                    game.snake.direction = Vector2(1, 0)

        game.draw()
        clock.tick(60)

if __name__ == '__main__':
    main()
