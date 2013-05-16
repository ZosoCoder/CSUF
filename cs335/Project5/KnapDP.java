import java.io.*;
import java.util.List;
import java.util.ArrayList;

public class KnapDP {
    private static ArrayList<Integer> knapsack(int[] w, int[] v, int max) {
        ArrayList<ArrayList<ArrayList<Integer>>> t = new ArrayList<ArrayList<ArrayList<Integer>>>();
        t.add(new ArrayList<ArrayList<Integer>>());
        t.add(new ArrayList<ArrayList<Integer>>());
        ArrayList<Integer> without = new ArrayList<Integer>();
        ArrayList<Integer> with = new ArrayList<Integer>();
        int i,j;

        for (i=0; i<2; i++) {
            for (j=0; j<=max; j++)
                t.get(i).add(new ArrayList<Integer>());
        } // End t initialization

        for (i=1; i<=v.length; i++) {
            for (j=1; j<=max; j++) {
                without = new ArrayList<Integer>(t.get((i-1)%2).get(j));
                if ((j - w[i-1]) >= 0) {
                    with = new ArrayList<Integer>(t.get((i-1)%2).get(j-w[i-1]));
                    if (!with.contains(i-1))
                        with.add(i-1);
                }
                if (value(without, v) > value(with, v))
                    t.get(i%2).set(j,without);
                else
                    t.get(i%2).set(j,with);
            }
        }

        return t.get(1).get(max);
    }

    private static int value(ArrayList<Integer> s, int[] v) {
        int total = 0;
        for (Integer i : s)
            total += v[i];
        return total;
    }

    private static int weight(ArrayList<Integer> s, int[] w) {
        int total = 0;
        for (Integer i : s)
            total += w[i];
        return total;
    }

    public static void main(String[] args) {
        int n = 0;
        int w = 0;
        if (args.length == 2) {
            try {
                n = Integer.parseInt(args[0]);
                w = Integer.parseInt(args[1]);
            } catch (NumberFormatException e) {
                System.err.println("Arguments must be of type int.");
                System.exit(1);
            }
        } else {
            System.out.println("You need to enter to inputs: n, W.");
            System.exit(1);
        }

        BufferedReader reader = null;
        String strRead = "";
        int[] weights = new int[n];
        int[] values = new int[n];
        Package[] pkgs = new Package[n];
        try {
            reader = new BufferedReader(new FileReader("packages.txt"));
        } catch (FileNotFoundException e) {
            System.out.println("Error: " + e);
        }

        try {
            strRead = reader.readLine();
            int count = 0;
            while ((strRead = reader.readLine()) != null && count < n) {
                String splitArray[] = strRead.split(" ");
                String pkgName = splitArray[0];
                int pkgVotes = Integer.parseInt(splitArray[1]);
                int pkgSize = Integer.parseInt(splitArray[2]);
                pkgs[count] = new Package(pkgName,pkgSize,pkgVotes);
                weights[count] = pkgSize;
                values[count] = pkgVotes;
                count++;
            }
        } catch (IOException e) {
            System.out.println("Error: " + e);
        }

        // Knapsack Algorithm
        Long start = System.currentTimeMillis();
        ArrayList<Integer> result = knapsack(weights,values,w);
        Long end = System.currentTimeMillis();

        int count = 0;
        for (Integer i : result) {
            System.out.println("Name=" + pkgs[i].getName() + " " +
                              "Votes=" + pkgs[i].getVotes() + " " +
                              "Size=" + pkgs[i].getSize());
            count++;
            if (count == 20)
                break;
        }
        System.out.println("Total: " + value(result,values));
        System.out.println("Size: " + weight(result,weights));
        System.out.println("Length: " + result.size());
        System.out.println("Milliseconds: " + (end-start));
    }
}