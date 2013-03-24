import java.util.Random;
import java.util.Scanner;

public class OptimalBS {
	public static void main(String[] args) {
		//Ask user for array size
		System.out.println("--Bubble Sort--");
		System.out.print("Size n of the array (int): ");
		Scanner input = new Scanner(System.in);
		int size = input.nextInt();

		//Initialize array and random number generator
		int[] array = new int[size];
		Random generator = new Random(481516);

		//Fill array with random ints
		for (int i=0; i<size; i++)
			array[i] = generator.nextInt(100);

		//Set start time
		long start = System.currentTimeMilis();

		//Bubble sort
		boolean swapped;
		int n = size;
		do {
			swapped = false;
			for (int i=1; i<n; i++) {
				if (array[i-1] > array[i]) {
					swap(array, i, i-1);
					swapped = true;
				}
			}
			n--;
		} while(swapped);

		//Get elapsed time
		long elapsed = System.currentTimeMillis() - start;

		System.out.println("\nBubble Sort time: " + elapsed + " nanoseconds.");
	}

	public static void swap(int[] a, int b, int c) {
		//Takes in an array and swaps two values at indices b and c
		int tmp = a[b];
		a[b] = a[c];
		a[c] = tmp;
	}

	public static void printArray(int[] a) {
		for (int i=0; i<a.length; i++)
			System.out.print(a[i] + " ");
	}
}