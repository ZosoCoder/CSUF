import java.util.Random;
import java.util.Scanner;

public class BubbleSort {
	public static void main(String[] args) {
		//Ask user for array size
		System.out.println("--Bubble Sort--");
		System.out.print("Size n of the array (int): ");
		Scanner input = new Scanner(System.in);
		int size = input.nextInt();

		//Initialize array and random number generator
		int[] array = new int[size];
		Random generator = new Random(481516);

		//File array with random ints
		for (int i=0; i<size; i++)
			array[i] = generator.nextInt(100);

		//Set start time
		long start = System.nanoTime();

		//Bubble Sort
		int min, i, j;
		for (i=0; i<size-1; i++) {
			for (j=0; j<size-i-1; j++) {
				if (array[j+1] < array[j])
					swap(array,j,j+1);
			}
		}

		//Get elapsed time
		long elapsed = System.nanoTime() - start;

		System.out.println("\nBubble Sort time: " + elapsed + " nanoseconds.");
	}

	public static void swap(int[] a, int b, int c) {
		//Takes in an array and swaps two values at indices b and c
		int tmp = a[b];
		a[b] = a[c];
		a[c] = tmp;
	}
}